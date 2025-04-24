<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Ensure UUID is treated as a string

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Generate UUID if not set
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
