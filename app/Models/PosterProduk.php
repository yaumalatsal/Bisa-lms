<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosterProduk extends Model
{
    use HasFactory;
    
    protected $table = 'poster_produk';

    protected $fillable = [
        'id_produk',
        'poster_produk',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
