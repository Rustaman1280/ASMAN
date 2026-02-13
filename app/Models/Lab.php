<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = ['jurusan_id', 'nama'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function barangs()
    {
        return $this->morphMany(Barang::class, 'lokasi');
    }
}
