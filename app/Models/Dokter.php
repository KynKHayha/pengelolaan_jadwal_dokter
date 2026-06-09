<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama_dokter',
        'spesialisasi',
        'no_telepon',
        'bio',
        'foto',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
