<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image">
    <button type="submit">Create Product</button>
</form>
