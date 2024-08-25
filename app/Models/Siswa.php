<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nomor_induk',
        'password',
        'tanggal_lahir',
        'nama',
    ];

    public function courseAnswers(){
        return $this->hasMany(CourseAnswer::class);
    }

    public function courseCompletion(){
        return $this->hasMany(CourseCompletion::class); 
    }
}
