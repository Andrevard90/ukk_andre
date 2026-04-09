<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'admin';
    protected $fillable = ['username', 'nama', 'password'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'username';
    }
}