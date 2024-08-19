<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $table = 'monthly_reports';

    protected $fillable = [
        'product_id',
        'total_sales',
        'report_date',
        'revenue',
        'spending',
        'user_id',
        'file_path', // Kolom baru untuk file PDF
        'status', // Add user_id here
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $dates = ['report_date'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getFormattedRevenueAttribute()
    {
        return 'Rp ' . number_format($this->revenue, 0, ',', '.');
    }

    public function getFormattedSpendingAttribute()
    {
        return 'Rp ' . number_format($this->spending, 0, ',', '.');
    }

    public function getProfitAttribute()
    {
        return $this->revenue - $this->spending; // Assuming spending is stored in total_sales
    }

    public function getFormattedProfitAttribute()
    {
        $profit = $this->profit;
        if ($profit > 0) {
            return '<span class="text-success">
                    <i class="fas fa-arrow-up"></i> Rp.  ' . number_format($profit, 2) . 
                '</span>';
        } elseif ($profit < 0) {
            return '<span class="text-danger">
                    <i class="fas fa-arrow-down"></i> Rp.  ' . number_format($profit, 2) . 
                '</span>';
        } else {
            return number_format($profit, 2);
        }
    }



}

