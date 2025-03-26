<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // Set key type to string

    public function category()
    {
        // Specify foreign key
        return $this->belongsTo(Category::class, 'categoryId'); 
    }

    protected $fillable = ['name', 'price', 'image', 'category_id'];

}
