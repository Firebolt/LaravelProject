<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h1>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">{{ $product->description }}</p>
                    <p class="text-gray-600 dark:text-gray-300">Price: ${{ $product->price }}</p>
                    <p class="text-gray-600 dark:text-gray-300">Stock Quantity: {{ $product->stock_quantity }}</p>
                    <p class="text-gray-600 dark:text-gray-300">Category: {{ $product->category->name }}</p>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <label for="payment_method" class="block text-gray-700 dark:text-gray-300 mt-2">Payment Method:</label>
                        <select id="payment_method" name="payment_method" class="block mt-1 w-full" required>
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="card">Card</option>
                        </select>
                        <label for="quantity" class="block text-gray-700 dark:text-gray-300">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock_quantity }}" class="block mt-1 w-full" required>
                        <input type="submit" value="Add to Cart" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>