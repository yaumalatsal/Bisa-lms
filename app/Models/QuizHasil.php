<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizHasil extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan tabel di database
    protected $table = 'quiz_hasils';

    // Daftar atribut yang bisa diisi massal (mass assignable)
    protected $fillable = [
        'user_id',
        'mapel_id',
        'nilai',
    ];

    // Mendefinisikan hubungan dengan model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'user_id');
    }

    // Mendefinisikan hubungan dengan model MapelsQuiz
    public function mapelsQuiz()
    {
        return $this->belongsTo(MapelsQuiz::class, 'mapel_id');
    }
}
