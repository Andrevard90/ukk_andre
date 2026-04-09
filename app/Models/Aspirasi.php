<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';

    protected $fillable = [
        'id_aspirasi',
        'id_pelaporan',
        'status',
        'id_kategori',
        'feedback',
        'siswa_feedback',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori','id_kategori');
    }

    public function inputAspirasi(){
        return $this->belongsTo(InputAspirasi::class,'id_pelaporan','id_pelaporan');
    }
}