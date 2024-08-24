
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterialStudent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_material_id',
        'siswa_id',
        'is_read'
    ];

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    public function courseMaterials() {
        return $this->belongsTo(CourseMaterial::class);
    }
}
