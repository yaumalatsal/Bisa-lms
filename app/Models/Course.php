<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'mentor_id',
        'status',
        'image'
    ];

    public function courseMaterials(){
        return $this->hasMany(CourseMaterial::class);
    }

    public function courseQuestions(){
        return $this->hasMany(CourseQuestion::class);
    }

    public function mentor(){
        return $this->belongsTo(Mentor::class);
    }



    
}
