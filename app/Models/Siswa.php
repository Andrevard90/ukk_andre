<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = ['nis','kelas','password'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'nis';
    }
}