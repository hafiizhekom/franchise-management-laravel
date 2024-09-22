<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranBulanan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer_pembayaran_bulanan';

    protected $fillable = [
        'customer_id',
        'period',
        'payment_date',
        'amount',
    ];

    protected $dates = ['deleted_at'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
