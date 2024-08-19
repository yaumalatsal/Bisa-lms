<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin'; // Define guard for this model

    protected $fillable = [
        'nama', 'email', 'password' // Add other fields as necessary
    ];

    protected $hidden = [
        'password'
    ];

}
