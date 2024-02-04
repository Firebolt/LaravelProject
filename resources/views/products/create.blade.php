@extends('layouts.app')
@section('content')
<x-guest-layout>
    <form method='POST' action=" {{ route('products.store') }}">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus autocomplete="description" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="category_id" :value="__('Category')" />
            <x-select-input id="category_id" class="block mt-1 w-full" name="category_id" :value="old('category_id')" required :options="$categories->pluck('name', 'id')->toArray()">
                <option value='' disabled selected>{{ __('Select a category') }}</option>
            </x-select-input>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" pattern="[0-9]+(\.[0-9]{2})?" :value="old('price')" required autofocus autocomplete="price" />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="stock_quantity" :value="__('Stock Quantity')" />
            <x-text-input id="stock_quantity" class="block mt-1 w-full" type="text" name="stock_quantity" pattern="[0-9]+" :value="old('stock_quantity')" required autofocus autocomplete="stock_quantity" />
            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
        </div>
        <div class="flex items-center justify-center mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('products.index') }}">
                {{ __('Cancel') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection