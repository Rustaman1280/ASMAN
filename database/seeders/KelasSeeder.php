<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Ruangan;

class KelasSeeder extends Seeder
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
                'nama' => 'Ruang Kelas X RPL 1',
            ], [
                'kategori' => 'Area Pembelajaran & Akademik',
                'jenis_ruangan' => 'Ruang Kelas',
                'tingkat' => 'X',
                'jurusan_id' => $rpl->id,
            ]);
        }

        if ($tkj) {
            Ruangan::firstOrCreate([
                'nama' => 'Ruang Kelas XI TKJ 1',
            ], [
                'kategori' => 'Area Pembelajaran & Akademik',
                'jenis_ruangan' => 'Ruang Kelas',
                'tingkat' => 'XI',
                'jurusan_id' => $tkj->id,
            ]);
        }
    }
}
