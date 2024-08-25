<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'id_mentor',
        'id_ceo',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }

    public function ceo()
    {
        return $this->belongsTo(Siswa::class, 'id_ceo');
    }

    public function logoProduk()
    {
        return $this->hasOne(LogoProduk::class, 'id_produk', 'id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_produk');
    }
}
