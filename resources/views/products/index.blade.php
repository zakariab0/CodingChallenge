@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Product List</h1>

    <div class="mb-4">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="parent_category_id">Parent Category</label>
                        <select id="parent_category_id" name="parent_category_id" class="form-control">
                            <option value="">Select Parent Category</option>
                            @foreach ($categories->whereNull('parent_id') as $parentCategory)
                                <option value="{{ $parentCategory->id }}" {{ request('parent_category_id') == $parentCategory->id ? 'selected' : '' }}>
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="subcategory_id">Subcategory</label>
                        <select id="subcategory_id" name="subcategory_id" class="form-control">
                            <option value="">Select Subcategory</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="price_min">Min Price</label>
                        <input type="number" id="price_min" name="price_min" class="form-control" value="{{ request('price_min') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="price_max">Max Price</label>
                        <input type="number" id="price_max" name="price_max" class="form-control" value="{{ request('price_max') }}">
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        @forelse ($products as $product)
            @php
                $productCategories = $product->categories;
                $parentCategory = $productCategories->firstWhere('parent_id', null);
                $subcategories = $productCategories->where('parent_id', '!=', null);
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p class="card-text"><strong>Parent Category:</strong> {{ $parentCategory ? $parentCategory->name : 'None' }}</p>
                        <p class="card-text"><strong>Subcategories:</strong>
                            @if($subcategories->isNotEmpty())
                                @foreach($subcategories as $subcategory)
                                    {{ $subcategory->name }}@if(!$loop->last), @endif
                                @endforeach
                            @else
                                None
                            @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <p>No products found.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subcategories = @json($categories->whereNotNull('parent_id')->groupBy('parent_id'));
        const parentCategorySelect = document.getElementById('parent_category_id');
        const subcategorySelect = document.getElementById('subcategory_id');

        parentCategorySelect.addEventListener('change', function () {
            const parentId = this.value;
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            // Add new options based on the selected parent category
            if (parentId && subcategories[parentId]) {
                subcategories[parentId].forEach(function (subcategory) {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            }
        });
        parentCategorySelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
