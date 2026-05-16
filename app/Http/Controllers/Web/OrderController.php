<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create()
    {
        return view('frontend.checkout.index');
    }

    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->createOrder(Auth::id(), $request->validated());
            return redirect()->route('home')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());
        return view('frontend.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        // Ensure user can only see their own order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('frontend.orders.show', compact('order'));
    }
}
