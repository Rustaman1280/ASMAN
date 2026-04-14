<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Ruangan;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rpl = Jurusan::where('kode', 'RPL')->first();
        $tkj = Jurusan::where('kode', 'TKJ')->first();

        if ($rpl) {
            Ruangan::firstOrCreate([
                'nama' => 'Lab RPL',
            ], [
                'kategori' => 'Area Pembelajaran & Akademik',
                'jenis_ruangan' => 'Ruang Laboratorium',
                'jurusan_id' => $rpl->id,
            ]);
        }

        if ($tkj) {
            Ruangan::firstOrCreate([
                'nama' => 'Lab TKJ',
            ], [
                'kategori' => 'Area Pembelajaran & Akademik',
                'jenis_ruangan' => 'Ruang Laboratorium',
                'jurusan_id' => $tkj->id,
            ]);
        }
    }
}
