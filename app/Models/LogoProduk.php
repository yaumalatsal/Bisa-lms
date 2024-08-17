<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoProduk extends Model
{
    use HasFactory;
    protected $table = 'logo_produk';

    protected $fillable = [
        'logo_produk',
        'id_produk',
        'deskripsi',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
