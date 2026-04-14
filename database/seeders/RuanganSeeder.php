<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Area Pembelajaran
        Ruangan::firstOrCreate([
            'nama' => 'Ruang Kelas X RPL 1',
        ], [
            'kategori' => 'Area Pembelajaran & Akademik',
            'jenis_ruangan' => 'Ruang Kelas',
            'tingkat' => '10',
            'jurusan_id' => 1, // Assuming RPL exists
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Lab Komputer 1',
        ], [
            'kategori' => 'Area Pembelajaran & Akademik',
            'jenis_ruangan' => 'Ruang Laboratorium',
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Perpustakaan Pusat',
        ], [
            'kategori' => 'Area Pembelajaran & Akademik',
            'jenis_ruangan' => 'Ruang Perpustakaan',
        ]);

        // Area Administrasi
        Ruangan::firstOrCreate([
            'nama' => 'Ruang Kepala Sekolah',
        ], [
            'kategori' => 'Area Administrasi & Manajemen',
            'jenis_ruangan' => 'Ruang Pimpinan',
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Ruang Guru Utama',
        ], [
            'kategori' => 'Area Administrasi & Manajemen',
            'jenis_ruangan' => 'Ruang Guru',
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Ruang Tata Usaha (TU)',
        ], [
            'kategori' => 'Area Administrasi & Manajemen',
            'jenis_ruangan' => 'Ruang TU (Tata Usaha)',
        ]);

        // Area Penunjang
        Ruangan::firstOrCreate([
            'nama' => 'Ruang OSIS',
        ], [
            'kategori' => 'Area Penunjang Pendidikan & Siswa',
            'jenis_ruangan' => 'Ruang OSIS',
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Ruang UKS',
        ], [
            'kategori' => 'Area Penunjang Pendidikan & Siswa',
            'jenis_ruangan' => 'Ruang UKS',
        ]);

        // Area Fasilitas Umum
        Ruangan::firstOrCreate([
            'nama' => 'Toilet Siswa Lantai 1',
        ], [
            'kategori' => 'Area Fasilitas Umum & Sanitasi',
            'jenis_ruangan' => 'Ruang Toilet',
        ]);

        Ruangan::firstOrCreate([
            'nama' => 'Gudang Pusat',
        ], [
            'kategori' => 'Area Fasilitas Umum & Sanitasi',
            'jenis_ruangan' => 'Ruang Gudang',
        ]);
        
        Ruangan::firstOrCreate([
            'nama' => 'Lapangan Olahraga',
        ], [
            'kategori' => 'Area Fasilitas Umum & Sanitasi',
            'jenis_ruangan' => 'Tempat Bermain / Olahraga',
        ]);
    }
}
