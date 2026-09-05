<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Investor extends Authenticatable
{
    use HasFactory;

    protected $guard = 'investor'; // Define guard for this model

    protected $fillable = [
        'nama', 'email', 'password', 'nomor_telepon', // Add other fields as necessary
    ];

    protected $hidden = [
        'password',
    ];
}
