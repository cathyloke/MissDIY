<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Sale;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
        'gender',
        'type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sales()
    {
        return $this->hasMany(Sale::class, 'userId', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'userId', 'id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'userId', 'id');
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }
    
    public function isCustomer()
    {
        return $this->type == 'customer';
    }
}
