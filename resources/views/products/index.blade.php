@extends('layout')

@section('content')
<div>
    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Parent Category</th>
                <th>Subcategory</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @foreach ($product->categories as $category)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if ($category->parent_id)
                                {{ $category->parent ? $category->parent->name : 'No Parent' }}
                            @else
                                {{ $category->name }}
                            @endif
                        </td>
                        <td>
                            @if ($category->parent_id)
                                {{ $category->name }}
                            @else
                                null
                            @endif
                        </td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                            @else
                                No Image
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
