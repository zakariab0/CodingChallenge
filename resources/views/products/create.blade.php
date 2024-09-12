<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to your CSS file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- Include jQuery -->
</head>
<body>
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
                @foreach ($subCategories as $subcategory)
                    <option value="{{ $subcategory->id }}" data-parent="{{ $subcategory->parent_id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Create Product</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#parent_category').change(function() {
                var parentId = $(this).val();
                $('#subcategories').empty(); // Clear previous options

                // Add back the options if no parent category is selected
                @foreach ($subCategories as $subcategory)
                    if (parentId === "{{ $subcategory->parent_id }}") {
                        $('#subcategories').append(
                            $('<option>', {
                                value: "{{ $subcategory->id }}",
                                text: "{{ $subcategory->name }}"
                            })
                        );
                    }
                @endforeach
            });
        });
    </script>
</body>
</html>
