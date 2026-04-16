<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Ruangan;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = Supplier::firstOrCreate([
            'nama_supplier' => 'CV Maju Jaya Abadi',
        ], [
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Teknologi No. 123, Jakarta',
        ]);

        $ruangKelas = Ruangan::where('nama', 'Ruang Kelas X RPL 1')->first();
        $labKomputer = Ruangan::where('nama', 'Lab Komputer 1')->first();
        $perpustakaan = Ruangan::where('nama', 'Perpustakaan Pusat')->first();
        $ruangKepsek = Ruangan::where('nama', 'Ruang Kepala Sekolah')->first();
        $ruangGuru = Ruangan::where('nama', 'Ruang Guru Utama')->first();
        $ruangTU = Ruangan::where('nama', 'Ruang Tata Usaha (TU)')->first();
        $ruangUKS = Ruangan::where('nama', 'Ruang UKS')->first();
        $gudang = Ruangan::where('nama', 'Gudang Pusat')->first();
        $lapangan = Ruangan::where('nama', 'Lapangan Olahraga')->first();

        $barangs = [
            // 1
            [
                'kode_barang' => 'BRG-MJA-01',
                'nama_barang' => 'Meja Siswa Standard',
                'merk_model' => 'Chitose',
                'no_seri_pabrik' => '-',
                'ukuran' => '60x40x75 cm',
                'bahan' => 'Kayu & Besi',
                'tahun_pembuatan' => '2022',
                'harga_perolehan' => 350000,
                'jumlah_baik' => 30,
                'jumlah_rusak_ringan' => 5,
                'jumlah_rusak_berat' => 1,
                'lokasi' => [
                    $ruangKelas ? ['id' => $ruangKelas->id, 'jumlah' => 36] : null
                ]
            ],
            // 2
            [
                'kode_barang' => 'BRG-KRS-02',
                'nama_barang' => 'Kursi Siswa Standard',
                'merk_model' => 'Chitose',
                'no_seri_pabrik' => '-',
                'ukuran' => 'Standard',
                'bahan' => 'Kayu & Besi',
                'tahun_pembuatan' => '2022',
                'harga_perolehan' => 250000,
                'jumlah_baik' => 34,
                'jumlah_rusak_ringan' => 2,
                'jumlah_rusak_berat' => 0,
                'lokasi' => [
                    $ruangKelas ? ['id' => $ruangKelas->id, 'jumlah' => 36] : null
                ]
            ],
            // 3
            [
                'kode_barang' => 'BRG-PC-03',
                'nama_barang' => 'PC Desktop',
                'merk_model' => 'Lenovo ThinkCentre',
                'no_seri_pabrik' => 'SN-LNV-001',
                'ukuran' => '-',
                'bahan' => 'Metal/Plastik',
                'tahun_pembuatan' => '2023',
                'harga_perolehan' => 9500000,
                'jumlah_baik' => 20,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'lokasi' => [
                    $labKomputer ? ['id' => $labKomputer->id, 'jumlah' => 20] : null
                ]
            ],
            // 4
            [
                'kode_barang' => 'BRG-RB-04',
                'nama_barang' => 'Rak Buku Besar',
                'merk_model' => 'IKEA Billy',
                'no_seri_pabrik' => '-',
                'ukuran' => '80x28x202 cm',
                'bahan' => 'Partikel Board',
                'tahun_pembuatan' => '2021',
                'harga_perolehan' => 1200000,
                'jumlah_baik' => 10,
                'jumlah_rusak_ringan' => 0,
                'jumlah_rusak_berat' => 0,
                'lokasi' => [
                    $perpustakaan ? ['id' => $perpustakaan->id, 'jumlah' => 10] : null
                ]
            ],
            // 5
            [
                'kode_barang' => 'BRG-AC-05',
                'nama_barang' => 'AC Split 1 PK',
                'merk_model' => 'Daikin',
                'no_seri_pabrik' => 'AC-DKN-005',
                'ukuran' => 'Standard',
                'bahan' => 'Plastik/Metal',
                'tahun_pembuatan' => '2024',
                'harga_perolehan' => 4500000,
                'jumlah_baik' => 2,
                'jumlah_rusak_ringan' => 1,
                'jumlah_rusak_berat' => 0,
                'lokasi' => [
                    $ruangGuru ? ['id' => $ruangGuru->id, 'jumlah' => 2] : null,
                    $ruangKepsek ? ['id' => $ruangKepsek->id, 'jumlah' => 1] : null
                ]
            ],
            // 6
            [
                'kode_barang' => 'BRG-LA-06',
                'nama_barang' => 'Lemari Arsip Besi',
                'merk_model' => 'Brother',
                'no_seri_pabrik' => '-',
                'ukuran' => '90x40x185 cm',
                'bahan' => 'Besi',
                'tahun_pembuatan' => '2020',
                'harga_perolehan' => 2300000,
                'jumlah_baik' => 4,
                'jumlah_rusak_ringan' => 1,
                'jumlah_rusak_berat' => 0,
                'lokasi' => [
                    $ruangTU ? ['id' => $ruangTU->id, 'jumlah' => 4] : null,
                    $gudang ? ['id' => $gudang->id, 'jumlah' => 1] : null
                ]
            ],
            // 7
            [
                'kode_barang' => 'BRG-BB-07',
                'nama_barang' => 'Bola Basket',
                'merk_model' => 'Spalding',
                'no_seri_pabrik' => '-',
                'ukuran' => 'Size 7',
                'bahan' => 'Kulit Sintetis',
                'tahun_pembuatan' => '2023',
                'harga_perolehan' => 600000,
                'jumlah_baik' => 5,
                'jumlah_rusak_ringan' => 2,
                'jumlah_rusak_berat' => 1,
                'lokasi' => [
                    $lapangan ? ['id' => $lapangan->id, 'jumlah' => 8] : null
                ]
            ],
        ];

        foreach ($barangs as $data) {
            $barang = Barang::updateOrCreate(
                ['kode_barang' => $data['kode_barang']],
                [
                    'nama_barang' => $data['nama_barang'],
                    'merk_model' => $data['merk_model'],
                    'no_seri_pabrik' => $data['no_seri_pabrik'],
                    'ukuran' => $data['ukuran'],
                    'bahan' => $data['bahan'],
                    'tahun_pembuatan' => $data['tahun_pembuatan'],
                    'harga_perolehan' => $data['harga_perolehan'],
                    'jumlah_baik' => $data['jumlah_baik'],
                    'jumlah_rusak_ringan' => $data['jumlah_rusak_ringan'],
                    'jumlah_rusak_berat' => $data['jumlah_rusak_berat'],
                    'supplier_id' => $supplier->id,
                ]
            );

            $syncData = [];
            foreach ($data['lokasi'] as $lokasi) {
                if ($lokasi && isset($lokasi['id'])) {
                    $syncData[$lokasi['id']] = ['jumlah' => $lokasi['jumlah']];
                }
            }
            if (count($syncData) > 0) {
                $barang->ruangans()->sync($syncData);
                
                // Re-sync units logic if identical to controller
                $this->syncUnits($barang);
            }
        }
    }

    private function syncUnits(Barang $b)
    {
        $kondisis = array_merge(
            array_fill(0, $b->jumlah_baik, 'baik'),
            array_fill(0, $b->jumlah_rusak_ringan, 'rusak_ringan'),
            array_fill(0, $b->jumlah_rusak_berat, 'rusak_berat')
        );
        $existingCount = $b->unitBarangs()->count();
        $targetCount = count($kondisis);
        
        if ($existingCount < $targetCount) {
            foreach ($kondisis as $i => $k) {
                if ($i < $existingCount) continue;
                $kodeUnit = $b->kode_barang . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                \App\Models\UnitBarang::updateOrCreate([
                    'barang_id' => $b->id,
                    'kode_unit' => $kodeUnit,
                ], [
                    'kondisi' => $k
                ]);
            }
        } elseif ($existingCount > $targetCount) {
             \App\Models\UnitBarang::where('barang_id', $b->id)->orderBy('id', 'desc')->take($existingCount - $targetCount)->delete();
        }

        $b->load('ruangans');
        $units = $b->unitBarangs()->orderBy('id')->get();
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
    }
}
