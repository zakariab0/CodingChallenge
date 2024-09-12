@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Product List</h1>
    <div class="row">
        @foreach ($products as $product)
            @foreach ($product->categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                <strong>Description:</strong> {{ $product->description }}<br>
                                <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                                <strong>Parent Category:</strong>
                                @if ($category->parent_id)
                                    {{ $category->parent ? $category->parent->name : 'No Parent' }}
                                @else
                                    {{ $category->name }}
                                @endif
                                <br>
                                <strong>Subcategory:</strong>
                                @if ($category->parent_id)
                                    {{ $category->name }}
                                @else
                                    null
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
