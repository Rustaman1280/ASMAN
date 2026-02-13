<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LabBarangExport;
use App\Imports\LabBarangImport;
use Maatwebsite\Excel\Facades\Excel;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $labs = \App\Models\Lab::with('jurusan')->withCount('barangs')->where('jurusan_id', $user->jurusan_id)->get();
        }
        else {
            $labs = \App\Models\Lab::with('jurusan')->withCount('barangs')->get();
        }
        return view('lab.index', compact('labs'));
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
        return view('lab.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat menambahkan lab untuk jurusan Anda sendiri.');
        }

        \App\Models\Lab::create($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil ditambahkan.');
    }

    public function show(\App\Models\Lab $lab)
    {
        $lab->load('barangs.supplier', 'jurusan');
        return view('lab.show', compact('lab'));
    }

    public function edit(\App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->role === 'guru_jurusan') {
            $jurusans = \App\Models\Jurusan::where('id', $user->jurusan_id)->get();
        }
        else {
            $jurusans = \App\Models\Jurusan::all();
        }

        return view('lab.edit', compact('lab', 'jurusans'));
    }

    public function update(Request $request, \App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama' => 'required|string|max:255',
        ]);

        if (auth()->user()->role === 'guru_jurusan' && $request->jurusan_id != auth()->user()->jurusan_id) {
            abort(403, 'Anda hanya dapat memindahkan lab ke jurusan Anda sendiri.');
        }

        $lab->update($request->all());

        return redirect()->route('labs.index')->with('success', 'Lab berhasil diperbarui.');
    }

    public function destroy(\App\Models\Lab $lab)
    {
        if (!auth()->user()->canEdit()) {
            abort(403);
        }

        if (auth()->user()->role === 'guru_jurusan' && $lab->jurusan_id !== auth()->user()->jurusan_id) {
            abort(403);
        }

        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab berhasil dihapus.');
    }

    public function exportBarang(\App\Models\Lab $lab)
    {
        $filename = 'barang-lab-' . str_replace(' ', '-', strtolower($lab->nama)) . '-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new LabBarangExport($lab), $filename);
    }

    public function importBarang(Request $request, \App\Models\Lab $lab)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new LabBarangImport($lab), $request->file('file'));
            return redirect()->route('labs.show', $lab)->with('success', 'Data barang berhasil diimpor ke lab ' . $lab->nama . '.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return redirect()->route('labs.show', $lab)->with('error', 'Gagal impor: ' . implode('; ', array_slice($errors, 0, 5)));
        } catch (\Exception $e) {
            return redirect()->route('labs.show', $lab)->with('error', 'Gagal impor: ' . $e->getMessage());
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
        return Excel::download($export, 'template-import-barang-lab.xlsx');
    }
}
