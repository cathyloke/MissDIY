<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleVoucher extends Model
{
    use HasFactory;

    protected $table = 'sales_voucher';

    protected $fillable = ['salesId', 'voucherId'];
}
