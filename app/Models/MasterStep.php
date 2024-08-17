<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStep extends Model
{
    use HasFactory;

    protected $table = 'master_step';

    protected $fillable = [
        'nama_step',
        'deskripsi',
        'route',
        'gambar',
        'step_number',
    ];
}
