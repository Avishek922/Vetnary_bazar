<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart(Auth::id());
        return view('frontend.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string'
        ]);

        try {
            $this->cartService->addToCart(Auth::id(), $request->product_id, $request->quantity, $request->size);
            return redirect()->back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove(\App\Models\Cart $cart)
    {
        $this->cartService->removeFromCart($cart->id);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
    
    public function update(Request $request, \App\Models\Cart $cart)
    {
         $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $this->cartService->updateQuantity($cart->id, $request->quantity);
        return redirect()->back()->with('success', 'Cart updated.');
    }
}
