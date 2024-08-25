<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'siswa_id',
        'completed',
        'score',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
