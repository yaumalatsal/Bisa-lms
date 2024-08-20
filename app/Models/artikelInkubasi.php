<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikelInkubasi extends Model
{
    use HasFactory;
    protected $table = 'artikel_inkubasis';

    protected $fillable = [
        'judul',
        'kategori',
        'bentuk_kategori',
        'link',
        'thumbnail',
    ];
}
