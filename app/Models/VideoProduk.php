<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProduk extends Model
{
    use HasFactory;

    protected $table = 'video_produk';

    protected $fillable = [
        'video_produk',
        'id_produk',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
