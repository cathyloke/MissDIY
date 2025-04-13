<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes; // ← Use SoftDeletes trait

    protected $table = 'product';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'price', 'image', 'categoryId'];

    protected $dates = ['deleted_at']; // ← Optional, if you're using Carbon date casting

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::random(13); 
            }
        });
    }
}
