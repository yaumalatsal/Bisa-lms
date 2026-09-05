<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mentor extends Authenticatable
{
    use HasFactory;

    protected $table = 'mentor';

    protected $guard = 'mentor';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_telepon',
        'umur',
        'instansi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_mentor');
    }
}
