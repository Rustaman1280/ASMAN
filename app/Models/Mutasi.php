<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $fillable = [
        'barang_id',
        'unit_barang_id',
        'user_id',
        'jenis_mutasi',
        'keterangan',
        'tanggal_mutasi',
        'status_awal',
        'status_akhir',
        'ruangan_awal_id',
        'ruangan_akhir_id',
        'nama_peminjam',
        'tanggal_kembali',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function unitBarang()
    {
        return $this->belongsTo(UnitBarang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruanganAwal()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_awal_id');
    }

    public function ruanganAkhir()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_akhir_id');
    }
}
