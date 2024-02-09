<?php
namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getAllOrders()
    {
        return Order::all();
    }

    public function getOrderById($orderId)
    {
        return Order::find($orderId);
    }

    public function createOrder($data)
    {
        return Order::create($data);
    }

    public function updateOrder($orderId, $data)
    {
        $order = $this->getOrderById($orderId);
        $order->update($data);

        return $order;
    }

    public function deleteOrder($orderId)
    {
        $order = $this->getOrderById($orderId);
        $order->delete();

        return $order;
    }
}
