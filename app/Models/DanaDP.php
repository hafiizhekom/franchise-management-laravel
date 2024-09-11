<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DanaDP extends Model
{
    use HasFactory;

    protected $table = 'customer_dana_dp';

    protected $fillable = [
        'dana_komitmen_id',
        'payment_date',
        'amount',
    ];

    public function danakomitmen(): BelongsTo
    {
        return $this->belongsTo(DanaKomitmen::class, 'dana_komitmen_id', 'id');
    }

    public function danapelunasan(): HasOne
    {
        return $this->hasOne(DanaPelunasan::class, 'dana_dp_id', 'id');
    }
}
