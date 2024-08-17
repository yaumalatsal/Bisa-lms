<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanBMC extends Model
{
    use HasFactory;
    protected $table = 'jawaban_bmc';

    protected $fillable = [
        'id_pertanyaan',
        'id_produk',
        'jawaban',
        'id_siswa',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanBMC::class, 'id_pertanyaan');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
