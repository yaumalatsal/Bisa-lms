<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentasi extends Model
{
    use HasFactory;

    protected $table = 'presentasi';

    protected $fillable = [
        'id_produk',
        'deck',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
