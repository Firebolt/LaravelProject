<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $name = $request->query('name');
        $category = $request->query('category');
        $price = $request->query('price');
        $Products = Product::all();
        $highestPrice = ceil($Products->max('price') / 10) * 10;
        if ($highestPrice < 10) {
            $highestPrice = 10;
        }
        $minPrice = $Products->min('price');
        if ($name) {
            $Products = $Products->where('name', 'like', '%' . $name . '%');
        }
        if ($category) {
            $Products = $Products->whereIn('category_id', $category);
        }
        if ($price) {
            $Products = $Products->where('price', '<=', $price);
        }
        $categories = Category::all();
        return view('products.index', ['Products' => $Products, 'categories' => $categories, 'highestPrice' => $highestPrice, 'minPrice' => $minPrice]);
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
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $productId)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        try {
            $this->productService->updateProduct($productId, $data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['update' => 'Failed to update product. Error: ' . $e->getMessage()]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($productId)
    {
        $this->productService->deleteProduct($productId);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
