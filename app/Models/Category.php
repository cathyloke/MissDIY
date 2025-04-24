<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category';
    protected $primaryKey = 'id';  
    protected $keyType = 'string';  
    public $incrementing = false;
    protected $fillable = ['name', 'description'];
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId');
    }

    public function getRouteKeyName()
    {
        return 'id';
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
