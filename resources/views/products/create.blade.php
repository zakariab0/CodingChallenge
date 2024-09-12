@extends('layout')

@section('content')
<div>
    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            @error('image')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Parent Categories Select -->
        <div>
            <label for="parent_category">Parent Categories:</label>
            <select id="parent_category" name="parent_category">
                <option value="">Select Parent Category</option>
                @foreach ($parentCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subcategories Select -->
        <div>
            <label for="subcategories">Subcategories:</label>
            <select id="subcategories" name="subcategories[]" multiple>
                <!-- Options will be dynamically loaded here -->
            </select>
        </div>

        <button type="submit">Create Product</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Convert server-side subcategories to JavaScript object
            const subcategories = @json($subCategories);

            // Convert object to array
            const subcategoriesArray = Object.values(subcategories);

            const parentCategorySelect = document.getElementById('parent_category');
            const subcategorySelect = document.getElementById('subcategories');

            parentCategorySelect.addEventListener('change', function () {
                const parentId = this.value;
                // Clear previous options
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
