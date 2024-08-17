<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackStep extends Model
{
    use HasFactory;

    protected $table = 'track_step';

    protected $fillable = [
        'id_siswa',
        'id_step',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function step()
    {
        return $this->belongsTo(MasterStep::class, 'id_step');
    }
}
