@extends('layouts.app')
@section('content')
    <table>
        <tr>
            <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Name</th>
            <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Price</th>
            <th class="font-bold text-xl px-4 w-1/2 text-gray-300 dark:text-gray-700">Description</th>
            <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Purchase</th>
        </tr>
        <tr>
            <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $product -> name }}</td>
            <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $product -> price }}€</td>
            <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $product -> description }}</td>

        </tr>
    </table>
@endsection