<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable {
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false; // Karena NIS bukan auto-increment
    protected $fillable = ['nis', 'kelas', 'password'];
    protected $hidden = ['password'];
}