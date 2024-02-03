<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderItemService;
class OrderItemCotnroller extends Controller
{
    private $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    public function index()
    {
        $orderItems = $this->orderItemService->getAllOrderItems();
        return view('order_items.index', compact('orderItems'));
    }

    public function show($id)
    {
        $orderItem = $this->orderItemService->getOrderItemById($id);
        return view('order_items.show', compact('orderItem'));
    }

    public function create()
    {
        return view('orders_items.create');
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'subtotal' => 'required|numeric',
        ]);

        $this->orderItemService->createOrderItem($data);

        return redirect()->route('order_items.index')->with('success', 'Order item created successfully.');
    }

    public function edit($id)
    {
        $orderItem = $this->orderItemService->getOrderItemById($id);
        return view('order_items.edit', compact('orderItem'));
    }

    public function update(Request $request, $id)
    {
        
        $data = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'subtotal' => 'required|numeric',
        ]);

        $this->orderItemService->updateOrderItem($id, $data);

        return redirect()->route('order_items.index')->with('success', 'Order item updated successfully.');
    }

    public function destroy($id)
    {
       
        $this->orderItemService->deleteOrderItem($id);

        return redirect()->route('order_items.index')->with('success', 'Order item deleted successfully.');
    }










}
