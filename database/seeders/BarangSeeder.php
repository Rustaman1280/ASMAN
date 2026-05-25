<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('seed_data.tsv');
        if (!file_exists($filePath)) {
            $this->command->error("File seed_data.tsv tidak ditemukan.");
            return;
        }

        $file = fopen($filePath, 'r');
        while (($line = fgets($file)) !== false) {
            $cols = explode("\t", trim($line));
            if (count($cols) < 32) continue;

            $kode_barang = trim($cols[1]);
            // Skip invalid or header rows
            if (empty($kode_barang) || $kode_barang == 'Kode Barang/') continue;
            
            $keadaan = strtoupper(trim($cols[12]));
            $volume = (int) str_replace(',', '', trim($cols[13]));
            
            $jmlBaik = 0;
            $jmlRusakRingan = 0;
            $jmlRusakBerat = 0;
            
            if ($keadaan === 'RB') $jmlRusakBerat = $volume;
            elseif ($keadaan === 'KB') $jmlRusakRingan = $volume;
            else $jmlBaik = $volume;

            $umurEkonomis = floatval(str_replace(',', '', trim($cols[18])));
            $masaManfaatBulan = $umurEkonomis > 0 ? (int)($umurEkonomis * 12) : null;

            $barang = Barang::updateOrCreate(
                ['kode_barang' => $kode_barang],
                [
                    'reg' => trim($cols[2]),
                    'kategori' => trim($cols[3]),
                    'nama_barang' => trim($cols[4]),
                    'alamat' => trim($cols[5]),
                    'merk_model' => trim($cols[6]),
                    'no_seri_pabrik' => trim($cols[7]),
                    'cara_perolehan' => trim($cols[8]),
                    'bulan_perolehan' => trim($cols[9]),
                    'tahun_pembuatan' => trim($cols[10]),
                    'ukuran' => trim($cols[11]),
                    'jumlah_baik' => $jmlBaik,
                    'jumlah_rusak_ringan' => $jmlRusakRingan,
                    'jumlah_rusak_berat' => $jmlRusakBerat,
                    'harga_perolehan' => floatval(str_replace(',', '', trim($cols[15]))),
                    'koreksi' => floatval(str_replace(',', '', trim($cols[17]))),
                    'masa_manfaat_bulan' => $masaManfaatBulan,
                    'penyusutan_sd_tahun_sebelumnya' => floatval(str_replace(',', '', trim($cols[19]))),
                    'beban_penyusutan_per_bulan' => floatval(str_replace(',', '', trim($cols[20]))),
                    'bulan_manfaat_sd_des_2024' => floatval(str_replace(',', '', trim($cols[22]))),
                    'akum_peny_sd_des_2024' => floatval(str_replace(',', '', trim($cols[23]))),
                    'koreksi_pembulatan' => floatval(str_replace(',', '', trim($cols[24]))),
                    'masa_manfaat_sd_mar_2025' => floatval(str_replace(',', '', trim($cols[25]))),
                    'beban_penyusutan_2025' => floatval(str_replace(',', '', trim($cols[26]))),
                    'akum_peny_sd_2025' => floatval(str_replace(',', '', trim($cols[27]))),
                    'nilai_buku' => floatval(str_replace(',', '', trim($cols[28]))),
                    'nama_opd' => trim($cols[29]),
                    'sub_opd' => trim($cols[30]),
                    'keterangan_mutasi' => trim($cols[31]),
                ]
            );

            $this->syncUnits($barang);
        }
        fclose($file);
        
        $this->command->info("Data barang berhasil di-seed dari TSV!");
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
    }
}
