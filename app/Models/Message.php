<?php

// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_siswa',
        'id_mentor',
        'message',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }
}
