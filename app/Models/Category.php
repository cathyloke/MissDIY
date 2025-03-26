<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $keyType = 'string';

    public function products()
    {
        // Specify the foreign key
        return $this->hasMany(Product::class, 'categoryId'); 
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
