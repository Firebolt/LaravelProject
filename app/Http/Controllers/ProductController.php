<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $Products = Product::all();
        return view('products.index', ['Products' => $Products]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
    }

    public function store()
    {
        $product = new Product([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'stock_quantity' => request('stock_quantity'),
            'category_id' => request('category_id'),
        ]);
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
