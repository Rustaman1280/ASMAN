<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'barang_id',
        'kode_unit',
        'lokasi_id',
        'lokasi_type',
        'kondisi',
        'detail_unit',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function lokasi()
    {
        return $this->morphTo();
    }
}
