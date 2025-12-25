<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'seller_id',
        'active',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
