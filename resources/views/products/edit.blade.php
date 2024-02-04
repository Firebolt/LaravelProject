@extends('layouts.app')
@section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('products.update', $id) }}">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$product->name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-area id="description" class="block mt-1 w-full" name="description" :value="$product->description" required />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="$product->price" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Stock Quantity -->
        <div class="mt-4">
            <x-input-label for="stock_quantity" :value="__('Stock Quantity')" />
            <x-text-input id="stock_quantity" class="block mt-1 w-full" type="number" name="stock_quantity" :value="$product->stock_quantity" required />
            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
        </div>

        <!-- Category -->
        <div class="mt-4">
            <x-input-label for="category_id" :value="__('Category')" />
            <select id="category_id" name="category_id" class="block mt-1 w-full" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('products.index') }}">
                {{ __('Cancel') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection