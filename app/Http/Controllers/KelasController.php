<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\KelasBarangExport;
use App\Imports\KelasBarangImport;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $kelas = \App\Models\Kelas::with('jurusan')->withCount('barangs')->where('jurusan_id', $user->jurusan_id)->get();
        }
        else {
            $kelas = \App\Models\Kelas::with('jurusan')->withCount('barangs')->get();
        }
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }
        return view('kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat menambahkan kelas untuk jurusan Anda sendiri.');
        }

        \App\Models\Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(\App\Models\Kelas $kelas)
    {
        $kelas->load('barangs.supplier', 'jurusan');
        return view('kelas.show', compact('kelas'));
    }

    public function edit(\App\Models\Kelas $kelas)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }

        return view('kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Kelas $kelas)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat memindahkan kelas ke jurusan Anda sendiri.');
        }

        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(\App\Models\Kelas $kelas)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $kelas->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function exportBarang(\App\Models\Kelas $kelas)
    {
        $filename = 'barang-kelas-' . str_replace(' ', '-', strtolower($kelas->nama)) . '-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new KelasBarangExport($kelas), $filename);
    }

    public function importBarang(Request $request, \App\Models\Kelas $kelas)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new KelasBarangImport($kelas), $request->file('file'));
            return redirect()->route('kelas.show', $kelas)->with('success', 'Data barang berhasil diimpor ke kelas ' . $kelas->nama . '.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return redirect()->route('kelas.show', $kelas)->with('error', 'Gagal impor: ' . implode('; ', array_slice($errors, 0, 5)));
        } catch (\Exception $e) {
            return redirect()->route('kelas.show', $kelas)->with('error', 'Gagal impor: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $export = new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
            public function array(): array
            {
                return [
                    ['Laptop Asus', 'Asus Vivobook', 'SN-12345', '14 inch', 'Plastik', '2024', 'BRG-001', 5, 0, 0, 7500000, '', 'CV Maju Jaya'],
                ];
            }
            public function headings(): array
            {
                return ['Nama Barang', 'Merk/Model', 'No Seri Pabrik', 'Ukuran', 'Bahan', 'Tahun Pembuatan', 'Nomor Kode Barang', 'Jumlah Baik', 'Jumlah Rusak Ringan', 'Jumlah Rusak Berat', 'Harga Perolehan', 'Keterangan Mutasi', 'Supplier'];
            }
            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']]]];
            }
        };
        return Excel::download($export, 'template-import-barang-kelas.xlsx');
    }
}
