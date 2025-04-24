<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SaleVoucher extends Model
{
    use HasFactory;

    protected $table = 'sales_voucher';

    protected $fillable = ['salesId', 'voucherId'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($saleVouchers) {
            $saleVouchers->id = Str::random(13);
        });
    }
}
