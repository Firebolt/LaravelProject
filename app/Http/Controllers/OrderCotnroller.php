<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderCotnroller extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $order = $this->orderService->getOrderById($orderId);
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $this->orderService->createOrder($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function edit($orderId)
    {
        $order = $this->orderService->getOrderById($orderId);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $orderId)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $this->orderService->updateOrder($orderId, $data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($orderId)
    {
        $this->orderService->deleteOrder($orderId);

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
