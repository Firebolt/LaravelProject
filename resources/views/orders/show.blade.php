@extends('layouts.app')
@section('content')
<div class="w-full min-h-screen">
    <div class="min-h-screen px-6">
        <table class="w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Product Name</th>
                    <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Quantity</th>
                    <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Price</th>
                    <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($OrderItems as $OrderItem)
                <tr>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $OrderItem->product->name }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $OrderItem->quantity }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">€{{ $OrderItem->product->price }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">€{{ $OrderItem->subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection