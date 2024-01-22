<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;


class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Your create view logic goes here
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            // Define your validation rules here
        ]);

        // Create a new transaction
        $this->transactionService->createTransaction($data);

        // Redirect to the index page with a success message
        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function updateStatus($transactionId, $newStatus)
    {
        // Update the status of a transaction
        $this->transactionService->updateTransactionStatus($transactionId, $newStatus);

        // Redirect back or to a specific page as needed
        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }

    public function getTransactionsForOrder($orderId)
    {
        // Get transactions for a specific order
        $transactions = $this->transactionService->getTransactionsForOrder($orderId);
        return view('transactions.for_order', compact('transactions'));
    }

    public function refund($transactionId)
    {
        // Refund a transaction
        $this->transactionService->refundTransaction($transactionId);

        // Redirect back or to a specific page as needed
        return redirect()->back()->with('success', 'Transaction refunded successfully.');
    }
}
