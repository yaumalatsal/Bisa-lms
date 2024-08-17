<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanBMC extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_bmc';

    protected $fillable = [
        'pertanyaan',
        'keterangan',
        'id_poin_bmc',
    ];
}
