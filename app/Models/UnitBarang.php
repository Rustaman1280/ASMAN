<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitBarang extends Model
{
    protected $fillable = [
        'barang_id',
        'kode_unit',
        'kondisi',
        'keterangan',
        'ruangan_id',
        'no_mesin',
        'no_rangka',
        'status',
        'harga_perolehan',
        'akumulasi_penyusutan',
        'nilai_buku',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
