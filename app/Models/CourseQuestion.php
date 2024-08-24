<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question_text'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function courseAnswers(){
        return $this->hasMany(CourseAnswer::class);
    }
}
