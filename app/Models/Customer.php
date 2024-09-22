<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'birthday',
        'gender',
        'email',
        'phone',
        'address',
        'city',
    ];

    protected $dates = ['deleted_at'];

    public function danakomitmen(): HasOne
    {
        return $this->hasOne(DanaKomitmen::class);
    }

    public function pembayaranbulanan(): HasMany
    {
        return $this->hasMany(PembayaranBulanan::class);
    }

    public function pembayaranperpanjangan(): HasMany
    {
        return $this->hasMany(PembayaranPerpanjangan::class);
    }

}
