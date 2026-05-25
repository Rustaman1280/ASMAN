<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merk_model',
        'no_seri_pabrik',
        'ukuran',
        'bahan',
        'tahun_pembuatan',
        'harga_perolehan',
        'jumlah_baik',
        'jumlah_rusak_ringan',
        'jumlah_rusak_berat',
        'keterangan_mutasi',
        'jenis',
        'kategori',
        'penanggungjawab',
        'masa_manfaat_bulan',
        'reg',
        'alamat',
        'cara_perolehan',
        'bulan_perolehan',
        'koreksi',
        'penyusutan_sd_tahun_sebelumnya',
        'beban_penyusutan_per_bulan',
        'bulan_manfaat_sd_des_2024',
        'akum_peny_sd_des_2024',
        'koreksi_pembulatan',
        'masa_manfaat_sd_mar_2025',
        'beban_penyusutan_2025',
        'akum_peny_sd_2025',
        'nilai_buku',
        'nama_opd',
        'sub_opd'
    ];

    public function ruangans()
    {
        return $this->belongsToMany(Ruangan::class, 'barang_ruangan')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    public function unitBarangs()
    {
        return $this->hasMany(UnitBarang::class);
    }

    public function getJumlahTotalAttribute()
    {
        return $this->jumlah_baik + $this->jumlah_rusak_ringan + $this->jumlah_rusak_berat;
    }
}
