@extends('layouts.app')
@section('content')
<div class="w-full min-h-screen">
    <div class="min-h-screen px-6">
        <table class="w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="font-bold text-xl px-4 text-gray-300 dark:text-gray-700">Status</th>
                    <th class="font-bold text-xl px-4 text-gray-300 dark:text-gray-700">Total price</th>
                    <th class="font-bold text-xl px-4 text-gray-300 dark:text-gray-700">Payment status</th>
                    <th class="font-bold text-xl px-4 text-gray-300 dark:text-gray-700">Payment method</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Orders as $Order)
                <tr>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $Order->status }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">€{{ $Order->total_price }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $Order->payment_method }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $Order->payment_status }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                        <a href="{{ route('orders.show', $Order->id) }}" class="hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border">See Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection