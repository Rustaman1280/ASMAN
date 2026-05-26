<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = Barang::with(['ruangans']);
        $user = auth()->user();

        if ($user && $user->isPjRuangan()) {
            $query->whereHas('ruangans', function ($q) use ($user) {
                $q->whereIn('ruangans.id', $user->ruangans->pluck('id'));
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('merk_model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('keadaan')) {
            if ($request->keadaan === 'baik') $query->where('jumlah_baik', '>', 0);
            if ($request->keadaan === 'rusak_ringan') $query->where('jumlah_rusak_ringan', '>', 0);
            if ($request->keadaan === 'rusak_berat') $query->where('jumlah_rusak_berat', '>', 0);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $perPage = $request->get('per_page', 15);
        $barangs = $query->latest()->paginate($perPage)->withQueryString();
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $ruangansQuery = Ruangan::query();
        if ($user && $user->isPjRuangan()) {
            $ruangansQuery->whereIn('id', $user->ruangans->pluck('id'));
        }
        $ruangans = $ruangansQuery->get();
        $preLokasiId = request('lokasi_id');
        $redirectTo = request('redirect_to');
        return view('barangs.create', compact('ruangans', 'preLokasiId', 'redirectTo'));
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
            'kategori' => 'nullable|string',
            'penanggungjawab' => 'nullable|string',
            'masa_manfaat_bulan' => 'nullable|integer',
            'reg' => 'nullable|string',
            'alamat' => 'nullable|string',
            'cara_perolehan' => 'nullable|string',
            'bulan_perolehan' => 'nullable|integer',
            'koreksi' => 'nullable|numeric',
            'penyusutan_sd_tahun_sebelumnya' => 'nullable|numeric',
            'beban_penyusutan_per_bulan' => 'nullable|numeric',
            'bulan_manfaat_sd_des_2024' => 'nullable|numeric',
            'akum_peny_sd_des_2024' => 'nullable|numeric',
            'koreksi_pembulatan' => 'nullable|numeric',
            'masa_manfaat_sd_mar_2025' => 'nullable|numeric',
            'beban_penyusutan_2025' => 'nullable|numeric',
            'akum_peny_sd_2025' => 'nullable|numeric',
            'nilai_buku' => 'nullable|numeric',
            'nama_opd' => 'nullable|string',
            'sub_opd' => 'nullable|string',
            'keterangan_mutasi' => 'nullable|string',
            'lokasi' => 'nullable|array',
            'lokasi.*.ruangan_id' => 'required|exists:ruangans,id',
            'lokasi.*.jumlah' => 'required|integer|min:1',
        ]);

        // Remove lokasi from validated data before creating barang
        $lokasiData = $validatedData['lokasi'] ?? [];
        unset($validatedData['lokasi']);

        $barang = Barang::create($validatedData);

        // Sync lokasi pivot
        $this->syncLokasi($barang, $lokasiData);

        $this->syncUnits($barang);

        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)->with('success', 'Barang berhasil ditambahkan.');
        }

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['ruangans']);
        return view('barangs.show', compact('barang'));
    }

    public function units(Barang $barang)
    {
        $query = $barang->unitBarangs()->with('ruangan');
        
        if (request()->has('ruangan_id')) {
            $query->where('ruangan_id', request('ruangan_id'));
            $filterRuanganId = request('ruangan_id');
        } else {
            $filterRuanganId = null;
        }

        $unitBarangs = $query->get();
        $barang->setRelation('unitBarangs', $unitBarangs);
        
        $barang->load('ruangans');
        $ruangans = Ruangan::all();
        
        return view('barangs.units', compact('barang', 'ruangans', 'filterRuanganId'));
    }

    public function updateUnit(Request $request, \App\Models\UnitBarang $unitBarang)
    {
        $validated = $request->validate([
            'keterangan' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'ruangan_id' => 'nullable|exists:ruangans,id',
        ]);

        $oldKondisi = $unitBarang->kondisi;
        $newKondisi = $validated['kondisi'];

        $unitBarang->update($validated);

        if ($oldKondisi !== $newKondisi) {
            $barang = $unitBarang->barang;
            $oldCol = 'jumlah_' . $oldKondisi;
            $newCol = 'jumlah_' . $newKondisi;
            
            if ($barang->$oldCol > 0) {
                $barang->$oldCol -= 1;
            }
            $barang->$newCol += 1;
            $barang->save();
        }

        return back()->with('success', 'Rincian unit berhasil diperbarui.');
    }

    public function edit(Barang $barang)
    {
        $user = auth()->user();

        $ruangansQuery = Ruangan::query();
        if ($user && $user->isPjRuangan()) {
            $ruangansQuery->whereIn('id', $user->ruangans->pluck('id'));
        }
        $ruangans = $ruangansQuery->get();
        $barang->load('ruangans');
        return view('barangs.edit', compact('barang', 'ruangans'));
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
            'kategori' => 'nullable|string',
            'penanggungjawab' => 'nullable|string',
            'masa_manfaat_bulan' => 'nullable|integer',
            'reg' => 'nullable|string',
            'alamat' => 'nullable|string',
            'cara_perolehan' => 'nullable|string',
            'bulan_perolehan' => 'nullable|integer',
            'koreksi' => 'nullable|numeric',
            'penyusutan_sd_tahun_sebelumnya' => 'nullable|numeric',
            'beban_penyusutan_per_bulan' => 'nullable|numeric',
            'bulan_manfaat_sd_des_2024' => 'nullable|numeric',
            'akum_peny_sd_des_2024' => 'nullable|numeric',
            'koreksi_pembulatan' => 'nullable|numeric',
            'masa_manfaat_sd_mar_2025' => 'nullable|numeric',
            'beban_penyusutan_2025' => 'nullable|numeric',
            'akum_peny_sd_2025' => 'nullable|numeric',
            'nilai_buku' => 'nullable|numeric',
            'nama_opd' => 'nullable|string',
            'sub_opd' => 'nullable|string',
            'keterangan_mutasi' => 'nullable|string',
            'lokasi' => 'nullable|array',
            'lokasi.*.ruangan_id' => 'required|exists:ruangans,id',
            'lokasi.*.jumlah' => 'required|integer|min:1',
        ]);

        // Remove lokasi from validated data before updating barang
        $lokasiData = $validatedData['lokasi'] ?? [];
        unset($validatedData['lokasi']);

        $barang->update($validatedData);

        // Sync lokasi pivot
        $this->syncLokasi($barang, $lokasiData);

        $this->syncUnits($barang);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Sync lokasi pivot table for a barang.
     */
    private function syncLokasi(Barang $barang, array $lokasiData)
    {
        $syncData = [];
        foreach ($lokasiData as $loc) {
            if (!empty($loc['ruangan_id'])) {
                // If same ruangan appears multiple times, sum the jumlah
                $rid = $loc['ruangan_id'];
                if (isset($syncData[$rid])) {
                    $syncData[$rid]['jumlah'] += (int) $loc['jumlah'];
                } else {
                    $syncData[$rid] = ['jumlah' => (int) $loc['jumlah']];
                }
            }
        }
        $barang->ruangans()->sync($syncData);
    }

    private function syncUnits(Barang $b)
    {
        // Simple append logic for now to make sure units reflect the capacity
        $kondisis = array_merge(
            array_fill(0, $b->jumlah_baik, 'baik'),
            array_fill(0, $b->jumlah_rusak_ringan, 'rusak_ringan'),
            array_fill(0, $b->jumlah_rusak_berat, 'rusak_berat')
        );
        $existingCount = $b->unitBarangs()->count();
        $targetCount = count($kondisis);
        
        $newUnitIds = [];
        if ($existingCount < $targetCount) {
            foreach ($kondisis as $i => $k) {
                if ($i < $existingCount) continue;
                $kodeUnit = $b->kode_barang . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                $unit = \App\Models\UnitBarang::create([
                    'barang_id' => $b->id,
                    'kode_unit' => $kodeUnit,
                    'kondisi' => $k
                ]);
                $newUnitIds[] = $unit->id;
            }
        } elseif ($existingCount > $targetCount) {
             // For deletions, we truncate the overflow units.
             // Normally this requires more complex ID mapping.
             \App\Models\UnitBarang::where('barang_id', $b->id)->orderBy('id', 'desc')->take($existingCount - $targetCount)->delete();
        }

        // Auto-assign ruangan_id based on pivot amounts
        $b->load('ruangans');
        $units = $b->unitBarangs()->orderBy('id')->get();
        // Reset all to null first to re-distribute
        \App\Models\UnitBarang::where('barang_id', $b->id)->update(['ruangan_id' => null]);
        
        $unitIdx = 0;
        foreach ($b->ruangans as $ruangan) {
            $quota = $ruangan->pivot->jumlah;
            for ($i = 0; $i < $quota; $i++) {
                if (isset($units[$unitIdx])) {
                    $units[$unitIdx]->ruangan_id = $ruangan->id;
                    $units[$unitIdx]->save();
                    $unitIdx++;
                }
            }
        }

        // Create mutasi history for newly added units
        if (!empty($newUnitIds)) {
            $userId = auth()->id();
            $freshNewUnits = \App\Models\UnitBarang::whereIn('id', $newUnitIds)->get();
            foreach ($freshNewUnits as $unit) {
                \App\Models\Mutasi::create([
                    'barang_id' => $b->id,
                    'unit_barang_id' => $unit->id,
                    'user_id' => $userId,
                    'jenis_mutasi' => 'penambahan',
                    'keterangan' => $b->keterangan_mutasi ?? 'Penambahan unit otomatis dari data barang.',
                    'tanggal_mutasi' => date('Y-m-d'),
                    'status_akhir' => $unit->kondisi,
                    'ruangan_akhir_id' => $unit->ruangan_id,
                ]);
            }
        }
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = $this->buildQuery($request);
        return Excel::download(new BarangExport($query), 'data-barang-' . date('Y-m-d') . '.xlsx');
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
                    [
                        1, '1.3.2.06.01.02.999', '', 'LAIN - LAIN PERALATAN STUDIO VIDEO DAN FILM', 'LAIN - LAIN PERALATAN STUDIO VIDEO DAN FILM', 
                        'SMKN 1 GARUT', 'DJI RONIN RS 4 Gimbal Stabilizer', '', 'BOS REGULER', 2, 2025, '', 'B', 1, 9250000, 9250000, 9250000, 
                        0, 8, 0, 0, 8, 0, 0, 0, 11, 1059905, 1059905, 8190095, 'DINAS PENDIDIKAN', 'SMKN 1 GARUT', 'KABUPATEN GARUT'
                    ],
                ];
            }
            public function headings(): array
            {
                return [
                    'No.',
                    'Kode Barang/ ID Barang',
                    'Reg.',
                    'Nama Barang Sesuai Permendagri 108',
                    'Nama Barang',
                    'Alamat',
                    'Merk / Tipe',
                    'No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi/ No. Ruas Jalan/ No. Daerah Irigasi',
                    'Cara Perolehan / Status Barang',
                    'Bulan Perolehan',
                    'Tahun Perolehan',
                    'Ukuran Barang / Konstruksi (P,SP,D)',
                    'Keadaan Barang (B,KB,RB)',
                    'Volume',
                    'Nilai Perolehan',
                    'Harga Satuan',
                    'Nilai Perolehan2',
                    'Koreksi',
                    'Umur Ekonomis',
                    'Penyusutan s.d Tahun Sebelumnya',
                    'Beban Penyusutan per Bulan',
                    'Umur Ekonomis2',
                    'Bulan Manfaat s.d 31 Des 2024',
                    'Akum Peny s.d 31 Des 2024',
                    'Koreksi Pembulatan',
                    'Masa Manfaat s.d 31 Mar 2025',
                    'Beban Penyusutan 2025',
                    'Akum Peny s.d 2025',
                    'Nilai Buku',
                    'Nama OPD',
                    'Sub OPD',
                    'Keterangan/ Tgl. Buku/ Tahun Sensus'
                ];
            }
            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']]]];
            }
        };
        return Excel::download($export, 'template-import-barang.xlsx');
    }
}
