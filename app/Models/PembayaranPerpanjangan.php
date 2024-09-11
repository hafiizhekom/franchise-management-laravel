<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPerpanjangan extends Model
{
    use HasFactory;

    protected $table = 'customer_pembayaran_perpanjangan';

    protected $fillable = [
        'customer_id',
        'tahun',
        'payment_date',
        'amount',
    ];
}
