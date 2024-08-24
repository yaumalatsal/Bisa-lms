<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $table = 'mentor';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_telepon',
        'umur',
        'instansi',
    ];

    public function courses() {
        return $this->hasMany(Course::class);
    }
}
