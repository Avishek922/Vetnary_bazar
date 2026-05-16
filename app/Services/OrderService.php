<?php

namespace App\Services;

use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;
    protected $cartRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function createOrder($userId, array $shippingDetails)
    {
        return DB::transaction(function () use ($userId, $shippingDetails) {
            $cartItems = $this->cartRepository->getCartByUserId($userId);
            
            if ($cartItems->isEmpty()) {
                throw new \Exception("Cart is empty");
            }

            $totalAmount = 0;
            $orderItems = [];

            // Calculate total and prepare items
            foreach ($cartItems as $item) {
                // Check stock again
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product {$item->product->name} is out of stock");
                }
                
                // Use sell_price (handles offers)
                $price = $item->product->sell_price;
                $totalAmount += $price * $item->quantity;
                
                $orderItems[] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'size' => $item->size
                ];

                // Deduct stock
                $this->productRepository->updateProduct($item->product_id, [
                    'stock' => $item->product->stock - $item->quantity
                ]);
            }

            // Create Order
            $orderData = [
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $shippingDetails['payment_method'],
                'delivery_address' => $shippingDetails['address'],
                'notes' => $shippingDetails['notes'] ?? null,
            ];

            $order = $this->orderRepository->createOrder($orderData);

            // Create Order Items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
                
                // Low Stock Alert Check
                $product = $this->productRepository->getProductById($item['product_id']);
                if ($product->stock <= 5) { // Threshold of 5
                    try {
                        // Send to admin or search for inventory manager
                        $adminEmail = config('mail.from.address', 'admin@vetshop.com');
                        \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\LowStockAlertEmail($product));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to send low stock alert: ' . $e->getMessage());
                    }
                }
            }

            // Clear Cart
            $this->cartRepository->clearCart($userId);

            // Send Order Confirmation Email to Customer
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderPlacedEmail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send Order Notification to Admin (Host)
            try {
                $adminEmail = config('mail.from.address', 'admin@vetshop.com');
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\AdminOrderReceivedEmail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send admin order notification: ' . $e->getMessage());
            }

            return $order;
        });
    }

    public function getUserOrders($userId)
    {
        return $this->orderRepository->getOrdersByUserId($userId);
    }
    
    public function getAllOrders() 
    {
        return $this->orderRepository->getAllOrders();
    }
}
