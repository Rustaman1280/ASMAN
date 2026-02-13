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
        'supplier_id',
        'lokasi_id',
        'lokasi_type',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function lokasi()
    {
        return $this->morphTo();
    }

    public function getJumlahTotalAttribute()
    {
        return $this->jumlah_baik + $this->jumlah_rusak_ringan + $this->jumlah_rusak_berat;
    }
}
