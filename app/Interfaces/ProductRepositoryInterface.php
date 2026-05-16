<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getProductById($productId);
    public function getProductBySlug($slug);
    public function createProduct(array $data);
    public function updateProduct($productId, array $newDetails);
    public function deleteProduct($productId);
    public function getActiveProducts();
    public function getProductsByCategory($categoryId);
    public function searchProducts(array $filters);
}
