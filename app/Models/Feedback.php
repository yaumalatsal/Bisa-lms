<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback';

    protected $fillable = [
        'id_step',
        'id_produk',
        'id_mentor',
        'judul',
        'komentar',
        'status',
    ];

    public function step()
    {
        return $this->belongsTo(MasterStep::class, 'id_step');
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
