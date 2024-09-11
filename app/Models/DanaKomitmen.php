<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DanaKomitmen extends Model
{
    use HasFactory;

    protected $table = 'customer_dana_komitmen';

    protected $fillable = [
        'customer_id',
        'payment_date',
        'amount',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function danadp(): HasOne
    {
        return $this->hasOne(DanaDP::class);
    }
}
