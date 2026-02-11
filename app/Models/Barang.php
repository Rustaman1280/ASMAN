<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stock_barang',
        'detail_barang',
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
}
