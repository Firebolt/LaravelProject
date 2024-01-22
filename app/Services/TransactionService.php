<?php
// TransactionService.php
namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function getAllTransactions()
    {
        return Transaction::all();
    }
    public function createTransaction($data)
    {
        return Transaction::create($data);
    }

    public function updateTransactionStatus($transactionId, $newStatus)
    {
        $transaction = Transaction::find($transactionId);
        if ($transaction) {
            $transaction->update(['status' => $newStatus]);
        }
    }

    public function getTransactionsForOrder($orderId)
    {
        return Transaction::where('order_id', $orderId)->get();
    }

     public function refundTransaction($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        if ($transaction && $transaction->status === 'completed') {
            
            $transaction->update(['status' => 'refunded']);

            
        }
    }

    
}
