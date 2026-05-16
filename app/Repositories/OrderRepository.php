<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAllOrders()
    {
        return Order::with('user', 'items.product', 'assignedAgent')->orderBy('created_at', 'desc')->get();
    }

    public function getOrderById($orderId)
    {
        return Order::with('user', 'items.product', 'payment')->findOrFail($orderId);
    }

    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function updateOrder($orderId, array $newDetails)
    {
        return Order::whereId($orderId)->update($newDetails);
    }

    public function deleteOrder($orderId)
    {
        return Order::destroy($orderId);
    }
    
    public function getOrdersByUserId($userId)
    {
        return Order::where('user_id', $userId)->with('items.product')->orderBy('created_at', 'desc')->get();
    }
}
