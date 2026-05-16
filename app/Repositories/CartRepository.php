<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function getCartByUserId($userId)
    {
        return Cart::where('user_id', $userId)->with('product')->get();
    }

    public function addToCart($userId, $productId, $quantity, $size = null)
    {
        // Check if exists
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->where('size', $size)
                        ->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
            return $cartItem;
        }

        return Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'size' => $size
        ]);
    }

    public function removeFromCart($cartId)
    {
        return Cart::destroy($cartId);
    }

    public function updateQuantity($cartId, $quantity)
    {
        return Cart::whereId($cartId)->update(['quantity' => $quantity]);
    }

    public function clearCart($userId)
    {
        return Cart::where('user_id', $userId)->delete();
    }
}
