<?php

namespace App\Services;

use App\Models\OrderItem;

class OrderItemService
{
    public function getAllOrderItems()
    {
        return OrderItem::all();
    }

    public function getOrderItemById($orderItemId)
    {
        return OrderItem::findOrFail($orderItemId);
    }

    public function createOrderItem($data)
    {
        return OrderItem::create($data);
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
