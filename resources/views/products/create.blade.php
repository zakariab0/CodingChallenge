@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control-file">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- parent categories -->
        <div class="form-group">
            <label for="parent_category">Parent Categories:</label>
            <select id="parent_category" name="parent_category" class="form-control">
                <option value="">Select Parent Category</option>
                @foreach ($parentCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- subcategories -->
        <div class="form-group">
            <label for="subcategories">Subcategories:</label>
            <select id="subcategories" name="subcategories[]" class="form-control" multiple>
                <!-- Options will be dynamically loaded here -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // fetch subcategories
            const subcategories = @json($subCategories);
            const subcategoriesArray = Object.values(subcategories);
            const parentCategorySelect = document.getElementById('parent_category');
            const subcategorySelect = document.getElementById('subcategories');

            parentCategorySelect.addEventListener('change', function () {
                const parentId = this.value;
                subcategorySelect.innerHTML = '';
                subcategoriesArray.forEach(function (subcategory) {
                    if (subcategory.parent_id == parentId || parentId === '') {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    }
                });
            });
        });
    </script>
</div>
@endsection
