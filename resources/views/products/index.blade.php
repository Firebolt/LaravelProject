@extends('layouts.app')
@section('content')
<div>
    @foreach ($Products as $Product)
        <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            {{ $Product -> name }}
            {{ $Product -> price }}
        </div>
    @endforeach
</div>
@endsection
