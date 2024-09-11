<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DanaPelunasan extends Model
{
    use HasFactory;

    protected $table = 'customer_dana_pelunasan';

    protected $fillable = [
        'dana_dp_id',
        'payment_date',
        'amount',
    ];

    public function danadp():BelongsTo
    {
        return $this->belongsTo(DanaDP::class,'dana_dp_id','id');
    }
    
}
