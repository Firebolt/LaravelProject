@extends('layouts.app')
@section('content')
    <table class="w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <thead>
            <tr>
                <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Name</th>
                <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Products</th>
                <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Edit</th>
                <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $category->name }}</td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                        <a href="{{ route('products.index', ['category' => $category->id]) }}">Products</a>
                    </td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                        <a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                    </td>
                    <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4"">
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection