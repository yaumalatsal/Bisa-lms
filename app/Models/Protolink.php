<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protolink extends Model
{
    use HasFactory;

    protected $table = 'protolink';

    protected $fillable = [
        'link_figma',
        'id_produk',
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
