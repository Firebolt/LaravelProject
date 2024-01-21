<?php
// CategoryService.php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCategoryById($categoryId)
    {
        return Category::find($categoryId);
    }

    public function createCategory($data)
    {
        return Category::create($data);
    }

    public function updateCategory($categoryId, $data)
    {
        $category = Category::find($categoryId);

        if ($category) {
            $category->update($data);
        }
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {
            $category->delete();
        }
    }
}
