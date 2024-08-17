<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBMC extends Model
{
    use HasFactory;
    protected $table = 'master_bmc';

    protected $fillable = [
        'judul',
        'deskripsi',
        'route',
        'icon',
        'video',
    ];
}
