<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelsQuiz extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan tabel di database
    protected $table = 'mapels_quiz';

    // Daftar atribut yang bisa diisi massal (mass assignable)
    protected $fillable = [
        'name',
        'durasi'
    ];

    public function quizSoals()
    {
        return $this->hasMany(QuizSoal::class, 'mapel_id');
    }


}
