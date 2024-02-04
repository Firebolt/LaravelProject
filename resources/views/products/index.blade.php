@extends('layouts.app')
@section('content')
<div class="flex min-h-screen">
    <div class="w-1/4 flex flex-col min-h-screen">
        <div class="    bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex-grow min-h-screen p-4">
            <p class="font-bold mb-4 text-gray-300 dark:text-gray-700" style="font-size: 2.5rem;">Filters</p>
            <form method="GET" action='/'>
                @csrf
                <div class="form-group mb-4">
                    <div class="form-label-group">
                        <label for="name" class="block text-gray-300 dark:text-gray-700 text-sm font-bold mb-2">Product name:</label>
                        <input type="text" name="name" id="name" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 dark:text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="form-label-group">
                        @foreach($categories as $category)
                            <input type="checkbox" name="category[]" value="{{ $category->name }}" id="category-{{ $category->name }}" checked class="mr-2 leading-tight" onclick="updateSelectAllCheckbox()">
                            <label for="category-{{ $category->name }}" class="text-gray-300 dark:text-gray-700 text-sm font-bold mb-2">{{ $category->name }}</label><br>
                        @endforeach
                        <input type="checkbox" id="select-all" name="select-all" onclick="selectAllCheckboxes(this)" checked class="mr-2 leading-tight">
                        <label for="select-all" class="text-gray-300 dark:text-gray-700 text-sm font-bold mb-2">Select All</label>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="form-label-group">
                        <label for="price" class="block text-gray-300 dark:text-gray-700 text-sm font-bold mb-2">Price: <span id="price-value"></span></label>
                        <input type="range" name="price" id="price" min="{{ $minPrice }}" max="{{ $highestPrice }}" value="{{ $highestPrice}}" step="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-300 dark:text-gray-700 leading-tight focus:outline-none focus:shadow-outline" oninput="updatePriceValue(this.value)">
                    </div>
                </div>
                <button class="hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border" type="submit">Filter</button>
            </form>
        </div>
    </div>
    <div class="w-full min-h-screen">
        <div class="min-h-screen px-6">
            <table class="w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <thead>
                    <tr>
                        <th class="font-bold text-xl px-4 w-1/2 text-gray-300 dark:text-gray-700">Name</th>
                        <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Price</th>
                        <th class="font-bold text-xl px-4 w-1/4 text-gray-300 dark:text-gray-700">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Products as $Product)
                    <tr>
                        <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $Product->name }}</td>
                        <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">{{ $Product->price }}</td>
                        <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                            <a href="{{ route('products.show', $Product->id) }}" class="hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border">See Details</a>
                        </td>
                        @auth
                            @if(auth()->user()->role === 'admin')
                            <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                                <a href="{{ route('products.edit', $Product->id) }}" class="hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border">Edit</a>
                            </td>
                            <td class="center-content text-gray-300 dark:text-gray-700 py-4 px-4">
                                <form method="POST" action="{{ route('products.destroy', $Product->id) }}">
                                    @csrf
                                    <button type="submit" class="hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border">Delete</button>
                                </form>
                            </td>
                            @endif
                        @endauth
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function selectAllCheckboxes(source) {
        var checkboxes = document.getElementsByName('category[]');
        for (var i = 0; i < checkboxes.length; i++)
            checkboxes[i].checked = source.checked;
    }

    function updatePriceValue(value) {
        document.getElementById('price-value').textContent = value + '€';
    }

    function updateSelectAllCheckbox() {
        var checkboxes = document.getElementsByName('category[]');
        var selectAllCheckbox = document.getElementById('select-all');
        for (var i = 0; i < checkboxes.length; i++) {
            if (!checkboxes[i].checked) {
                selectAllCheckbox.checked = false;
                return;
            }
        }
        selectAllCheckbox.checked = true;
    }

    window.onload = function() {
        updatePriceValue(document.getElementById('price').value);
    }
</script>
@endsection