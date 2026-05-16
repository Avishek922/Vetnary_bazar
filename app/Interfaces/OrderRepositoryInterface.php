<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function getAllOrders();
    public function getOrderById($orderId);
    public function createOrder(array $data);
    public function updateOrder($orderId, array $newDetails);
    public function deleteOrder($orderId);
    public function getOrdersByUserId($userId);
}
