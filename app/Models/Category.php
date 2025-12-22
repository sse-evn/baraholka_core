<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug ??= Str::slug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                // Обновляем slug только если он не был явно задан пользователем
                // (т.е. если slug не изменился вручную в этом запросе)
                if (!$category->isDirty('slug')) {
                    $category->slug = Str::slug($category->name);
                }
            }
        });
    }
    protected $fillable = [
        'name',
        'slug',
    ];
}
