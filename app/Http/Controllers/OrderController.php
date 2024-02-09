<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\OrderItemService;
use Exception;

class OrderController extends Controller
{
    protected $productService;
    protected $orderService;
    protected $orderItemService;

    public function __construct(
        OrderService $orderService,
        OrderItemService $orderItemService,
        ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
        $this->productService = $productService;
    }

    public function index()
    {
        $Orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('Orders'));
    }

    public function show($id)
    {
        $Order = $this->orderService->getOrderById($id);
        if ($Order === null)
            return redirect()->route('orders.index')->withErrors(['order' => 'Order not found.']);
        $OrderItems = $Order->orderItems;
        return view('orders.show', compact('Order', 'OrderItems'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method' => 'required|string|in:cash_on_delivery,card',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $this->productService->getProductById($request->product_id);
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->withInput()->withErrors(['stock' => 'Product ' . $product->name . ' is out of stock.']);
        }

        $product->stock_quantity -= $request->quantity;
        $product->save();

        $data['user_id'] = auth()->user()->id;
        $data['total_price'] = $product->price * $request->quantity;
        $data['status'] = 'processing';
        if ($data['payment_method'] === 'cash_on_delivery')
            $data['payment_status'] = 'NA';
        else 
            $data['payment_status'] = 'pending';

        $order = $this->orderService->createOrder($data);
        $orderData = [
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'subtotal' => $product->price * $request->quantity,
        ];

        $this->orderItemService->createOrderItem($orderData);

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
            'transaction_method' => 'required|string',
            'transaction_status' => 'required|string',
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
