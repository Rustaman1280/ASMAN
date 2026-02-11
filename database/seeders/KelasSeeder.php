<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Jurusan;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rpl = Jurusan::where('kode', 'RPL')->first();
        $tkj = Jurusan::where('kode', 'TKJ')->first();

        Kelas::create(['jurusan_id' => $rpl->id, 'nama' => 'X RPL 1', 'tingkat' => 'X']);
        Kelas::create(['jurusan_id' => $tkj->id, 'nama' => 'XI TKJ 1', 'tingkat' => 'XI']);
    }
}
