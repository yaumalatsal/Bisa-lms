<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSoal extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan tabel di database
    protected $table = 'quiz_soals';

    // Daftar atribut yang bisa diisi massal (mass assignable)
    protected $fillable = [
        'mapel_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'key',
    ];

    // Mendefinisikan hubungan dengan model MapelsQuiz
    public function mapelsQuiz()
    {
        return $this->belongsTo(MapelsQuiz::class, 'mapel_id');
    }
}
