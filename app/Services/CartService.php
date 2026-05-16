<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;

class CartService
{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function getCart($userId)
    {
        return $this->cartRepository->getCartByUserId($userId);
    }

    public function addToCart($userId, $productId, $quantity, $size = null)
    {
        $product = $this->productRepository->getProductById($productId);
        if ($product->stock < $quantity) {
            throw new \Exception("Insufficient stock");
        }
        return $this->cartRepository->addToCart($userId, $productId, $quantity, $size);
    }

    public function removeFromCart($cartId)
    {
        return $this->cartRepository->removeFromCart($cartId);
    }

    public function updateQuantity($cartId, $quantity)
    {
        return $this->cartRepository->updateQuantity($cartId, $quantity);
    }
    
    public function clearCart($userId) 
    {
        return $this->cartRepository->clearCart($userId);
    }
}
