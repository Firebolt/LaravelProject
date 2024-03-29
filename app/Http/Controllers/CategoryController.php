<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $category = new Category([
            'name' => $data['name'],
        ]);
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $categoryId)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $this->categoryService->updateCategory($categoryId, $data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($categoryId)
    {
        $this->categoryService->deleteCategory($categoryId);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
