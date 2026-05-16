<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class AdminController extends Controller
{
    protected $orderRepo;
    protected $productRepo;
    protected $userRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ProductRepositoryInterface $productRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
    }

    public function dashboard()
    {
        $orders = $this->orderRepo->getAllOrders();
        $totalOrders = $orders->count();
        $totalProducts = $this->productRepo->getAllProducts()->count();
        $totalUsers = $this->userRepo->getAllUsers()->count();
        $recentOrders = $orders->take(5);

        // Calculate Revenue and Profit from Delivered Orders
        $deliveredOrders = $orders->where('status', 'delivered');
        $totalRevenue = $deliveredOrders->sum('total_amount');
        
        $totalProfit = 0;
        foreach ($deliveredOrders as $order) {
            foreach ($order->items as $item) {
                // We use the product's CURRENT buying price if not stored in order item
                // Ideally, buying price should be snapshotted at the time of purchase
                // For now, we use the current product's buying price
                $buyingPrice = $item->product ? ($item->product->buying_price ?? 0) : 0;
                $profitPerItem = $item->price - $buyingPrice;
                $totalProfit += ($profitPerItem * $item->quantity);
            }
        }

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalUsers', 
            'recentOrders',
            'totalRevenue',
            'totalProfit'
        ));
    }
}
