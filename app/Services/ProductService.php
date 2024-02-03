<?php

// app/Services/ProductService.php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($productId)
    {
        return Product::findOrFail($productId);
    }

    public function createProduct($data)
    {
        return Product::create($data);
    }

    public function updateProduct($productId, $data)
    {
        $product = $this->getProductById($productId);
        $product->update($data);
        return $product;
    }

    public function deleteProduct($productId)
    {
        $product = $this->getProductById($productId);
        $product->delete();
    }
}
