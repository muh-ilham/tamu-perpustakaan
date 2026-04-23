<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'pangkat',
        'satuan',
        'judul_buku',
        'foto_path',
    ];
}
