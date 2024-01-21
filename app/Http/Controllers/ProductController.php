<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', ['products' => $products]);
    }

    public function show($productId)
    {
        $product = $this->productService->getProductById($productId);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'stock_quantity' => 'required|integer',
        ]);

        $this->productService->createProduct($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
        //////i have not create the views files
    }

    public function edit($productId)
    {
        $product = $this->productService->getProductById($productId);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        $data = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'stock_quantity' => 'required|integer',
            
        ]);

        $this->productService->updateProduct($productId, $data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($productId)
    {
        $this->productService->deleteProduct($productId);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
