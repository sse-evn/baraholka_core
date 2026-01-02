<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class FixProductImageUrls extends Command
{
    protected $signature = 'fix:product-images';
    protected $description = 'Исправляет image_url в продуктах — оставляет только относительный путь';

    public function handle()
    {
        $this->info('Начинаю исправление image_url...');

        Product::whereNotNull('image_url')->chunk(50, function ($products) {
            foreach ($products as $product) {
                $newUrl = $product->image_url;

                $newUrl = preg_replace('#^(/storage/|https?://[^/]+/storage/|storage/app/public/)#i', '', $newUrl);

                if (!str_starts_with($newUrl, 'products/')) {
                    $newUrl = 'products/' . basename($newUrl);
                }

                $product->image_url = $newUrl;
                $product->save();

                $this->line(" {$product->id}: {$product->name} → {$newUrl}");
            }
        });

        $this->info('Все image_url исправлены.');
    }
}