<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';

    protected $fillable = [
        'id_produk',
        'id_siswa',
        'position',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
