<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById($categoryId);
    public function getCategoryBySlug($slug);
    public function createCategory(array $data);
    public function updateCategory($categoryId, array $newDetails);
    public function deleteCategory($categoryId);
    public function getRootCategories();
}
