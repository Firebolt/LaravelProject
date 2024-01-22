<?php

namespace App\Services;

use App\Models\OrderItems;

class OrderItemService
{
    public function getAllOrderItems()
    {
        return OrderItems::all();
    }

    public function getOrderItemById($orderItemId)
    {
        return OrderItems::findOrFail($orderItemId);
    }

    public function createOrderItem($data)
    {
        return OrderItems::create($data);
    }

    public function updateOrderItem($orderItemId, $data)
    {
        $orderItems = $this->getOrderItemById($orderItemId);
        $orderItems->update($data);

        return $orderItems;
    }

    public function deleteOrderItem($orderItemId)
    {
        $orderItems = $this->getOrderItemById($orderItemId);
        $orderItems->delete();

        return $orderItems;
    }
}
