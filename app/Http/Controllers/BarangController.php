<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Kelas;
use App\Models\Lab;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with(['supplier', 'lokasi'])->get();
        $suppliers = Supplier::all();
        return view('barangs.index', compact('barangs', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        $preLokasiType = request('lokasi_type');
        $preLokasiId = request('lokasi_id');
        $redirectTo = request('redirect_to');
        return view('barangs.create', compact('suppliers', 'kelas', 'labs', 'preLokasiType', 'preLokasiId', 'redirectTo'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:barangs,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'merk_model' => 'nullable|string|max:255',
            'no_seri_pabrik' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:4',
            'harga_perolehan' => 'nullable|numeric|min:0',
            'jumlah_baik' => 'required|integer|min:0',
            'jumlah_rusak_ringan' => 'required|integer|min:0',
            'jumlah_rusak_berat' => 'required|integer|min:0',
            'keterangan_mutasi' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'lokasi_type' => 'nullable|in:kelas,lab',
            'lokasi_id' => 'nullable|integer',
        ]);

        if (!empty($validatedData['lokasi_type'])) {
            $validatedData['lokasi_type'] = $validatedData['lokasi_type'] === 'kelas' ? Kelas::class : Lab::class;
        }

        Barang::create($validatedData);

        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)->with('success', 'Barang berhasil ditambahkan.');
        }

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['supplier', 'lokasi']);
        return view('barangs.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $suppliers = Supplier::all();
        $kelas = Kelas::all();
        $labs = Lab::all();
        return view('barangs.edit', compact('barang', 'suppliers', 'kelas', 'labs'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'merk_model' => 'nullable|string|max:255',
            'no_seri_pabrik' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:4',
            'harga_perolehan' => 'nullable|numeric|min:0',
            'jumlah_baik' => 'required|integer|min:0',
            'jumlah_rusak_ringan' => 'required|integer|min:0',
            'jumlah_rusak_berat' => 'required|integer|min:0',
            'keterangan_mutasi' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'lokasi_type' => 'nullable|in:kelas,lab',
            'lokasi_id' => 'nullable|integer',
        ]);

        if (!empty($validatedData['lokasi_type'])) {
            $validatedData['lokasi_type'] = $validatedData['lokasi_type'] === 'kelas' ? Kelas::class : Lab::class;
        } else {
            $validatedData['lokasi_type'] = null;
            $validatedData['lokasi_id'] = null;
        }

        $barang->update($validatedData);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'data-barang-' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new BarangImport, $request->file('file'));
            return redirect()->route('barangs.index')->with('success', 'Data barang berhasil diimpor dari Excel.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return redirect()->route('barangs.index')->with('error', 'Gagal impor: ' . implode('; ', array_slice($errors, 0, 5)));
        } catch (\Exception $e) {
            return redirect()->route('barangs.index')->with('error', 'Gagal impor: ' . $e->getMessage());
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
        return Excel::download($export, 'template-import-barang.xlsx');
    }
}
