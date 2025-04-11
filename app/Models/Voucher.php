<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher';

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sales_voucher', 'voucherId', 'salesId');
    }
}
