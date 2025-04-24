<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'userId' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->id = Str::random(13);
        });
    }

    protected $fillable = [
        'id',
        'date',
        'totalAmount',
        'netTotalAmount',
        'status',
        'userId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'salesId', 'id');
    }

    public function voucher()
    {
        return $this->belongsToMany(Voucher::class, 'sales_voucher', 'salesId', 'voucherId');
    }
}
