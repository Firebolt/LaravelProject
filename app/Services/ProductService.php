<?php

// app/Services/ProductService.php

namespace App\Services;

use App\Models\Products;

class ProductService
{
    public function getAllProducts()
    {
        return Products::all();
    }

    public function getProductById($productId)
    {
        return Products::findOrFail($productId);
    }

    public function createProduct($data)
    {
        return Products::create($data);
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
