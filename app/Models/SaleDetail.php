<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sales_details';

    protected $fillable = [
        'quantity',
        'productId',
        'salesId',
        'userId',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($saleDetails) {
            $saleDetails->id = Str::random(13);
        });
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'salesId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
