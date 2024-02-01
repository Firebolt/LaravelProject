<head>
</head>
@extends('layouts.app')
@section('content')
<link href="{{ asset('sb-admin.css') }}" rel="stylesheet">
<div class='container'>
    <div class='card card-login mx-auto mt-5'>
        <div class='card-header'>Create a product"</div>
        <div class='card-body'>
            <form method='POST' action='/'>
                @csrf
                <div class='form-group'>
                    <div class='form-label-group'>
                        <input type='text' name='name' id='name' class='form-control' required='required'>
                        <label for='name'>Product name:</label>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='description'>Description:</label>
                    <div class='form-label-group'>
                        <textarea name='description' id='description' class='form-control' required='required'></textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='category_id'>Category:</label>
                    <div class='form-label-group'>
                        <select name='category_id' id='category_id' class='form-control' required>
                            <option value='' disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value='{{ $category->id }}'>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='form-group'>
                    <div class='form-label-group'>
                        <input type='number' name='price' id='price' step='0.01' class='form-control' required='required'>
                        <label for='price'>Price:</label>
                    </div>
                </div>
                <div class='form-group'>
                    <div class='form-label-group'>
                        <input type='number' name='stock_quantity' id='stock_quantity' min='0' class='form-control' required='required'>
                        <label for='stock_quantity'>Stock Quantity:</label>
                    </div>
                </div>
                <input class='btn btn-primary btn-block' type='submit' value='Confirm'>
                <a class='btn btn-primary btn-block' href='/'>Back</a>
            </form>
        </div>
    </div>
</div>
@endsection