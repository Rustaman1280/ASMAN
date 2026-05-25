<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BarangImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    private $ruanganCache = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $kodeBarang = $row['kode_barang_id_barang'] ?? $row['kode_barang'] ?? null;
            $namaBarang = $row['nama_barang'] ?? null;

            if (!$kodeBarang || !$namaBarang) {
                continue; // Skip rows without mandatory identifiers
            }

            $keadaan = strtoupper(trim($row['keadaan_barang_bkbrb'] ?? 'B'));
            $volume = (int) ($row['volume'] ?? 1);
            
            $jmlBaik = 0;
            $jmlRusakRingan = 0;
            $jmlRusakBerat = 0;
            
            if ($keadaan === 'RB') {
                $jmlRusakBerat = $volume;
            } elseif ($keadaan === 'KB') {
                $jmlRusakRingan = $volume;
            } else {
                $jmlBaik = $volume;
            }

            $umurEkonomis = floatval($row['umur_ekonomis'] ?? 0);
            $masaManfaatBulan = $umurEkonomis > 0 ? (int)($umurEkonomis * 12) : null;

            // Find or create Barang
            $barang = Barang::firstOrCreate(
                ['kode_barang' => $kodeBarang],
                [
                    'nama_barang' => $namaBarang,
                    'kategori' => $row['nama_barang_sesuai_permendagri_108'] ?? null,
                    'merk_model' => $row['merk_tipe'] ?? null,
                    'no_seri_pabrik' => $row['no_sertifikat_no_pabrik_no_chasis_no_mesin_no_polisi_no_ruas_jalan_no_daerah_irigasi'] ?? null,
                    'tahun_pembuatan' => $row['tahun_perolehan'] ?? null,
                    'harga_perolehan' => $row['harga_satuan'] ?? 0,
                    'ukuran' => $row['ukuran_barang_konstruksi_pspd'] ?? null,
                    'keterangan_mutasi' => $row['keterangan_tgl_buku_tahun_sensus'] ?? null,
                    'masa_manfaat_bulan' => $masaManfaatBulan,
                    'jumlah_baik' => $jmlBaik,
                    'jumlah_rusak_ringan' => $jmlRusakRingan,
                    'jumlah_rusak_berat' => $jmlRusakBerat,
                    
                    'reg' => $row['reg'] ?? null,
                    'alamat' => $row['alamat'] ?? null,
                    'cara_perolehan' => $row['cara_perolehan_status_barang'] ?? null,
                    'bulan_perolehan' => $row['bulan_perolehan'] ?? null,
                    'koreksi' => floatval($row['koreksi'] ?? 0),
                    'penyusutan_sd_tahun_sebelumnya' => floatval($row['penyusutan_sd_tahun_sebelumnya'] ?? 0),
                    'beban_penyusutan_per_bulan' => floatval($row['beban_penyusutan_per_bulan'] ?? 0),
                    'bulan_manfaat_sd_des_2024' => floatval($row['bulan_manfaat_sd_31_des_2024'] ?? 0),
                    'akum_peny_sd_des_2024' => floatval($row['akum_peny_sd_31_des_2024'] ?? 0),
                    'koreksi_pembulatan' => floatval($row['koreksi_pembulatan'] ?? 0),
                    'masa_manfaat_sd_mar_2025' => floatval($row['masa_manfaat_sd_31_mar_2025'] ?? 0),
                    'beban_penyusutan_2025' => floatval($row['beban_penyusutan_2025'] ?? 0),
                    'akum_peny_sd_2025' => floatval($row['akum_peny_sd_2025'] ?? 0),
                    'nilai_buku' => floatval($row['nilai_buku'] ?? 0),
                    'nama_opd' => $row['nama_opd'] ?? null,
                    'sub_opd' => $row['sub_opd'] ?? null,
                ]
            );

            // Update if necessary
            if (!$barang->wasRecentlyCreated) {
                $barang->increment('jumlah_baik', $jmlBaik);
                $barang->increment('jumlah_rusak_ringan', $jmlRusakRingan);
                $barang->increment('jumlah_rusak_berat', $jmlRusakBerat);
            }
            
            // Re-sync units
            $this->syncUnits($barang);
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
                \App\Models\UnitBarang::create([
                    'barang_id' => $b->id,
                    'kode_unit' => $kodeUnit,
                    'kondisi' => $k
                ]);
            }
        }
    }
}
