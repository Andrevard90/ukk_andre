<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    protected $fillable = ['nis','id_kategori','lokasi','ket'];

    public function aspirasi(){
        return $this->hasOne(Aspirasi::class,'id_pelaporan');
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori');
    }
}