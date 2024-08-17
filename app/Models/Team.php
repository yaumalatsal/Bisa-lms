<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'team';

    protected $fillable = [
        'id_siswa',
        'id_produk',
        'position',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
