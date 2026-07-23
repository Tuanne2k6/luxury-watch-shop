<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}