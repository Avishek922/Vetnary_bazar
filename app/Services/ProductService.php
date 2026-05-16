<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Str;

class ProductService
{
    protected $productRepository;
    protected $fileUploadService;

    public function __construct(ProductRepositoryInterface $productRepository, FileUploadService $fileUploadService)
    {
        $this->productRepository = $productRepository;
        $this->fileUploadService = $fileUploadService;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function createProduct(array $data, array $images = [])
    {
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);
        
        if (!empty($images)) {
            $data['images'] = $this->fileUploadService->uploadMultiple($images, 'products');
        }

        // Initialize top-level defaults
        if (!isset($data['price'])) $data['price'] = 0;
        if (!isset($data['buying_price'])) $data['buying_price'] = 0;
        if (!isset($data['stock'])) $data['stock'] = 0;

        // Handle specifications if passed as array
        if (isset($data['specifications']) && is_array($data['specifications'])) {
            // Already array, model casts it
        }

        // Handle sizes from structured variants array (new format)
        if (isset($data['variants']) && is_array($data['variants'])) {
            $formattedSizes = [];
            $minPrice = null;
            $minBuyingPrice = null;
            $totalStock = 0;

            $totalStock = 0;

            foreach ($data['variants'] as $variant) {
                if (!empty($variant['size'])) {
                    $price = (float) ($variant['price'] ?? 0);
                    $buyingPrice = (float) ($variant['buying_price'] ?? 0);
                    $stock = (int) ($variant['stock'] ?? 0);

                    $formattedSizes[] = [
                        'size' => $variant['size'],
                        'price' => $price,
                        'buying_price' => $buyingPrice,
                        'stock' => $stock
                    ];

                    // Calculate aggregates
                    if ($minPrice === null || $price < $minPrice) $minPrice = $price;
                    if ($minBuyingPrice === null || $buyingPrice < $minBuyingPrice) $minBuyingPrice = $buyingPrice;
                    $totalStock += $stock;
                }
            }

            $data['sizes'] = $formattedSizes;
            
            // Sync top-level attributes if variants exist
            if (!empty($formattedSizes)) {
                $data['price'] = $minPrice ?? 0;
                $data['buying_price'] = $minBuyingPrice ?? 0;
                $data['stock'] = $totalStock;
            }
        }
        // Handle sizes from comma-separated string (legacy fallback)
        elseif (isset($data['sizes']) && is_string($data['sizes'])) {
            $sizesArray = [];
            $parts = array_filter(array_map('trim', explode(',', $data['sizes'])));
            
            foreach ($parts as $part) {
                if (strpos($part, ':') !== false) {
                    [$size, $price] = explode(':', $part, 2);
                    $sizesArray[] = [
                        'size' => trim($size),
                        'price' => (float) trim($price),
                        'buying_price' => 0, // Default for legacy
                        'stock' => 0        // Default for legacy
                    ];
                } else {
                    $sizesArray[] = trim($part);
                }
            }
            $data['sizes'] = $sizesArray;
        }

        return $this->productRepository->createProduct($data);
    }

    public function updateProduct($id, array $data, array $images = [])
    {
        $product = $this->productRepository->getProductById($id);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);
        }

        if (!empty($images)) {
            // Optionally delete old images or append. Here replacing for simplicity or appending? 
            // Usually we append or replace. Let's append for now or handle via specific logic.
            // For now, let's assume we replace implicitly if new images provided, or just add.
            // Implementation choice: Just add new ones to existing list.
            $newImages = $this->fileUploadService->uploadMultiple($images, 'products');
            $currentImages = $product->images ?? [];
            $data['images'] = array_merge($currentImages, $newImages);
        }

        // Handle sizes from structured variants array (new format)
        if (isset($data['variants']) && is_array($data['variants'])) {
            $formattedSizes = [];
            $minPrice = null;
            $minBuyingPrice = null;
            $totalStock = 0;

            foreach ($data['variants'] as $variant) {
                if (!empty($variant['size'])) {
                    $price = (float) ($variant['price'] ?? 0);
                    $buyingPrice = (float) ($variant['buying_price'] ?? 0);
                    $stock = (int) ($variant['stock'] ?? 0);

                    $formattedSizes[] = [
                        'size' => $variant['size'],
                        'price' => $price,
                        'buying_price' => $buyingPrice,
                        'stock' => $stock
                    ];

                    // Calculate aggregates
                    if ($minPrice === null || $price < $minPrice) $minPrice = $price;
                    if ($minBuyingPrice === null || $buyingPrice < $minBuyingPrice) $minBuyingPrice = $buyingPrice;
                    $totalStock += $stock;
                }
            }

            $data['sizes'] = $formattedSizes;
            
            // Sync top-level attributes if variants exist
            if (!empty($formattedSizes)) {
                $data['price'] = $minPrice ?? 0;
                $data['buying_price'] = $minBuyingPrice ?? 0;
                $data['stock'] = $totalStock;
            }
        }
        // Handle sizes from formatted string (e.g., "1kg:500, 5kg:2000" or "S, M, L")
        elseif (isset($data['sizes']) && is_string($data['sizes'])) {
            $sizesArray = [];
            $parts = array_filter(array_map('trim', explode(',', $data['sizes'])));
            
            foreach ($parts as $part) {
                if (strpos($part, ':') !== false) {
                    // Format: "size:price"
                    [$size, $price] = explode(':', $part, 2);
                    $sizesArray[] = [
                        'size' => trim($size),
                        'price' => (float) trim($price),
                        'buying_price' => 0,
                        'stock' => 0
                    ];
                } else {
                    // Legacy format: just size names (no price)
                    $sizesArray[] = trim($part);
                }
            }
            
            $data['sizes'] = $sizesArray;
        }

        return $this->productRepository->updateProduct($id, $data);
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepository->getProductById($id);
        if ($product->images) {
            foreach ($product->images as $image) {
                $this->fileUploadService->delete($image);
            }
        }
        return $this->productRepository->deleteProduct($id);
    }
    
    public function getProductBySlug($slug)
    {
        return $this->productRepository->getProductBySlug($slug);
    }

    public function searchProducts(array $filters)
    {
        return $this->productRepository->searchProducts($filters);
    }
}
