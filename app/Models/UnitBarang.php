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
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
