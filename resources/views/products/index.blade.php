<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to your CSS file -->
</head>
<body>
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
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
