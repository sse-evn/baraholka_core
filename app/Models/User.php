<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function favorites()
{
    return $this->belongsToMany(Product::class, 'favorites');
}
}