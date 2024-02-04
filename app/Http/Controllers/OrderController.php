<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\OrderItemService;
use Exception;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderItemService;

    public function __construct(OrderService $orderService, OrderItemService $orderItemService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $order = $this->orderService->getOrderById($orderId);
        $orderItems = $order->orderItems;
        return view('orders.show', compact('order', 'orderItems'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $this->orderService->createOrder($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function edit($orderId)
    {
        $order = $this->orderService->getOrderById($orderId);
        $orderItems = $order->orderItems;
        return view('orders.edit', compact('order', 'orderItems'));
    }

    public function update(Request $request, $orderId)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        try {
            $this->orderService->updateOrder($orderId, $data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['update' => 'Failed to update product. Error: ' . $e->getMessage()]);
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($orderId)
    {
        $this->orderService->deleteOrder($orderId);

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
