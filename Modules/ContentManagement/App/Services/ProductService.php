<?php

namespace Modules\ContentManagement\App\Services;

use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\App\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts()
    {
        return $this->productRepository->getProducts();
    }

    public function update(array $data)
    {

        return $this->productRepository->updateProducts($data);
    }

    public function downloadProductFile()
    {
        $file_path = $this->productRepository->getFilePath();
        // $file_path = "files/FkFo64dTb4lz28Byu3RLqo5I3RbUiO898d0uVFgz.jpg";

        if (! $file_path || ! Storage::disk('public')->exists($file_path)) {
            abort(404);
        }
        // $filename = basename($file_path);
        // $file_size = Storage::size($file_path);
        // dd($file_path, $filename, $file_size);

        // Optionally, set a default filename using the product's title
        $product = $this->productRepository->getProducts();
        // dd($product);
        $downloadName = $product->title.'.'.pathinfo($file_path, PATHINFO_EXTENSION);

        // dd($downloadName);
        // dd($file_path, $downloadName);
        return Storage::disk('public')->download($file_path, $downloadName);
    }
}
