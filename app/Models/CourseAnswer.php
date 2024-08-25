<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'siswa_id',
        'answer_text',
        'score'
    ];

    public function courseQuestion(){
        return $this->belongsTo(CourseQuestion::class, 'question_id');
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
