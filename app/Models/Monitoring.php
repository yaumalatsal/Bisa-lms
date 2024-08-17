<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_process', 
        'value',
        'product',
        'quantity',
        'price',
        'date',
        'file_path',
    ];
}
