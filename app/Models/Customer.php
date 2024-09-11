<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

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

    public function danakomitmen(): HasOne
    {
        return $this->hasOne(DanaKomitmen::class);
    }

}
