<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = ['nama', 'kode'];

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class);
    }



    public function users()
    {
        return $this->hasMany(User::class);
    }
}
