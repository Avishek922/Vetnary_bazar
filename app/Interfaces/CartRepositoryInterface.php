<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function getCartByUserId($userId);
    public function addToCart($userId, $productId, $quantity, $size = null);
    public function removeFromCart($cartId);
    public function updateQuantity($cartId, $quantity);
    public function clearCart($userId);
}
