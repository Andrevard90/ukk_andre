<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi'; // <-- pastikan sesuai nama tabel di database

    protected $fillable = [
    'nis',
    'id_kategori',
    'lokasi',
    'keterangan',
    'foto',
    'tanggal',

];
}