<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $table = 'monthly_reports';

    /*
     | The `status` column is enum('pending','disetujui','ditolak'). The approve
     | and reject actions used to write 'Disetujui' / 'Ditolak' with a capital
     | letter, which MySQL rejects in strict mode and truncates to '' otherwise —
     | so an approved report never matched the lowercase value the views and the
     | monitoring queries compare against. Use these constants instead.
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'disetujui';

    public const STATUS_REJECTED = 'ditolak';

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

    protected $casts = [
        'report_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getFormattedRevenueAttribute()
    {
        return 'Rp '.number_format($this->revenue, 0, ',', '.');
    }

    public function getFormattedSpendingAttribute()
    {
        return 'Rp '.number_format($this->spending, 0, ',', '.');
    }

    public function getProfitAttribute()
    {
        return $this->revenue - $this->spending; // Assuming spending is stored in total_sales
    }

    /**
     * Profit as Indonesian rupiah.
     *
     * This used to return an HTML <span> with US grouping ("Rp.  5,700,000.00"),
     * which both disagreed with every other amount in the app and forced the
     * views to render it unescaped. The colour and arrow are the view's job.
     */
    public function getFormattedProfitAttribute(): string
    {
        return 'Rp '.number_format($this->profit, 0, ',', '.');
    }
}
