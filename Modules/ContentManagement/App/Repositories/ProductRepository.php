<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\Product;

class ProductRepository
{
    public function getProducts()
    {
        return Product::first();
    }

    public function updateProducts(array $data)
    {
        $product = Product::first();

        if (! $product) {
            $product = Product::create($data);
        } else {
            $product->update($data);
        }

        return $product;
    }

    public function getFilePath()
    {
        $product = $this->getProducts();
        $file_path = $product->file;

        // dd($file_path);
        return $file_path;
    }
}
