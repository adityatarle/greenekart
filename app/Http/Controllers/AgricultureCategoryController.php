<?php

namespace App\Http\Controllers;

use App\Models\AgricultureCategory;
use App\Models\AgricultureProduct;
use Illuminate\Http\Request;

class AgricultureCategoryController extends Controller
{
    public function index()
    {
        $categories = AgricultureCategory::active()
            ->ordered()
            ->withCount('products')
            ->withCount(['products as in_stock_products_count' => function($query) {
                $query->where('is_active', true)
                      ->where('in_stock', true);
            }])
            ->get();
        return view('agriculture.categories.index', compact('categories'));
    }
    
    public function show(string $category)
    {
        $categoryModel = AgricultureCategory::where('slug', $category)
            ->where('is_active', true)
            ->firstOrFail();

        $products = AgricultureProduct::active()
            ->inStock()
            ->byCategory($categoryModel->id)
            ->with('category')
            ->paginate(12);

        $otherCategories = AgricultureCategory::active()
            ->where('id', '!=', $categoryModel->id)
            ->ordered()
            ->withCount('products')
            ->limit(6)
            ->get();

        return view('agriculture.categories.show', [
            'category' => $categoryModel,
            'products' => $products,
            'otherCategories' => $otherCategories,
        ]);
    }
}