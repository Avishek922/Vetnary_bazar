<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($productId)
    {
        return Product::findOrFail($productId);
    }

    public function getProductBySlug($slug)
    {
        return Product::where('slug', $slug)->firstOrFail();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($productId, array $newDetails)
    {
        $product = Product::findOrFail($productId);
        $product->update($newDetails);
        return $product;
    }

    public function deleteProduct($productId)
    {
        return Product::destroy($productId);
    }

    public function getActiveProducts()
    {
        return Product::where('is_active', true)->get();
    }
    
    public function getProductsByCategory($categoryId)
    {
        return Product::where('category_id', $categoryId)->where('is_active', true)->get();
    }

    public function searchProducts(array $filters)
    {
        $query = Product::query();

        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Support for multiple category IDs (for subcategory filtering)
        if (isset($filters['category_ids']) && !empty($filters['category_ids'])) {
            $query->whereIn('category_id', $filters['category_ids']);
        }

        if (isset($filters['active_only']) && $filters['active_only'] === true) {
            $query->where('is_active', true);
        }

        return $query->with('category')->get();
    }
}
