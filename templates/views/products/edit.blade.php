@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </h2>
                    <p class="text-muted mb-0">Update product information for "{{ $product->name }}"</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Product
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>

            <!-- Edit Product Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-box me-2"></i>Product Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.update', $product) }}" method="POST" id="editProductForm" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                Product Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $product->name) }}" 
                                                   required 
                                                   maxlength="255"
                                                   placeholder="Enter product name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">
                                                SKU <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('sku') is-invalid @enderror" 
                                                   id="sku" 
                                                   name="sku" 
                                                   value="{{ old('sku', $product->sku) }}" 
                                                   required 
                                                   maxlength="100"
                                                   placeholder="Enter SKU">
                                            @error('sku')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Stock Keeping Unit - unique identifier for the product
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category and Supplier -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">
                                                Category <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                                    id="category_id" 
                                                    name="category_id" 
                                                    required>
                                                <option value="">Select Category</option>
                                                @foreach($categories ?? [] as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="supplier_id" class="form-label">Supplier</label>
                                            <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                                    id="supplier_id" 
                                                    name="supplier_id">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers ?? [] as $supplier)
                                                    <option value="{{ $supplier->id }}" 
                                                            {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              maxlength="1000"
                                              placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Detailed description of the product. Maximum 1000 characters.
                                    </div>
                                </div>

                                <!-- Pricing and Stock -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">
                                                Price <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       class="form-control @error('price') is-invalid @enderror" 
                                                       id="price" 
                                                       name="price" 
                                                       value="{{ old('price', $product->price) }}" 
                                                       required 
                                                       step="0.01" 
                                                       min="0"
                                                       placeholder="0.00">
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="cost_price" class="form-label">Cost Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       class="form-control @error('cost_price') is-invalid @enderror" 
                                                       id="cost_price" 
                                                       name="cost_price" 
                                                       value="{{ old('cost_price', $product->cost_price) }}" 
                                                       step="0.01" 
                                                       min="0"
                                                       placeholder="0.00">
                                            </div>
                                            @error('cost_price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Purchase cost for profit calculation
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">
                                                Current Stock <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('quantity') is-invalid @enderror" 
                                                   id="quantity" 
                                                   name="quantity" 
                                                   value="{{ old('quantity', $product->quantity) }}" 
                                                   required 
                                                   min="0"
                                                   placeholder="0">
                                            @error('quantity')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Current stock level
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Management -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="low_stock_threshold" class="form-label">Low Stock Threshold</label>
                                            <input type="number" 
                                                   class="form-control @error('low_stock_threshold') is-invalid @enderror" 
                                                   id="low_stock_threshold" 
                                                   name="low_stock_threshold" 
                                                   value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 10) }}" 
                                                   min="0"
                                                   placeholder="10">
                                            @error('low_stock_threshold')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Alert when stock falls below this level
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="reorder_point" class="form-label">Reorder Point</label>
                                            <input type="number" 
                                                   class="form-control @error('reorder_point') is-invalid @enderror" 
                                                   id="reorder_point" 
                                                   name="reorder_point" 
                                                   value="{{ old('reorder_point', $product->reorder_point ?? 5) }}" 
                                                   min="0"
                                                   placeholder="5">
                                            @error('reorder_point')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Stock level to trigger reorder
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="max_stock" class="form-label">Maximum Stock</label>
                                            <input type="number" 
                                                   class="form-control @error('max_stock') is-invalid @enderror" 
                                                   id="max_stock" 
                                                   name="max_stock" 
                                                   value="{{ old('max_stock', $product->max_stock) }}" 
                                                   min="0"
                                                   placeholder="100">
                                            @error('max_stock')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Maximum stock level to maintain
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">Brand</label>
                                            <input type="text" 
                                                   class="form-control @error('brand') is-invalid @enderror" 
                                                   id="brand" 
                                                   name="brand" 
                                                   value="{{ old('brand', $product->brand) }}" 
                                                   maxlength="100"
                                                   placeholder="Enter brand name">
                                            @error('brand')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="model" class="form-label">Model</label>
                                            <input type="text" 
                                                   class="form-control @error('model') is-invalid @enderror" 
                                                   id="model" 
                                                   name="model" 
                                                   value="{{ old('model', $product->model) }}" 
                                                   maxlength="100"
                                                   placeholder="Enter model number">
                                            @error('model')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Dimensions and Weight -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">Weight (kg)</label>
                                            <input type="number" 
                                                   class="form-control @error('weight') is-invalid @enderror" 
                                                   id="weight" 
                                                   name="weight" 
                                                   value="{{ old('weight', $product->weight) }}" 
                                                   step="0.01" 
                                                   min="0"
                                                   placeholder="0.00">
                                            @error('weight')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="length" class="form-label">Length (cm)</label>
                                            <input type="number" 
                                                   class="form-control @error('length') is-invalid @enderror" 
                                                   id="length" 
                                                   name="length" 
                                                   value="{{ old('length', $product->length) }}" 
                                                   step="0.1" 
                                                   min="0"
                                                   placeholder="0.0">
                                            @error('length')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="width" class="form-label">Width (cm)</label>
                                            <input type="number" 
                                                   class="form-control @error('width') is-invalid @enderror" 
                                                   id="width" 
                                                   name="width" 
                                                   value="{{ old('width', $product->width) }}" 
                                                   step="0.1" 
                                                   min="0"
                                                   placeholder="0.0">
                                            @error('width')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="height" class="form-label">Height (cm)</label>
                                            <input type="number" 
                                                   class="form-control @error('height') is-invalid @enderror" 
                                                   id="height" 
                                                   name="height" 
                                                   value="{{ old('height', $product->height) }}" 
                                                   step="0.1" 
                                                   min="0"
                                                   placeholder="0.0">
                                            @error('height')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Images -->
                                <div class="mb-3">
                                    <label for="images" class="form-label">Product Images</label>
                                    <input type="file" 
                                           class="form-control @error('images') is-invalid @enderror" 
                                           id="images" 
                                           name="images[]" 
                                           multiple 
                                           accept="image/*">
                                    @error('images')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Upload new product images (JPG, PNG, GIF). Multiple images allowed.
                                    </div>
                                    
                                    <!-- Current Images -->
                                    @if($product->images && count($product->images) > 0)
                                        <div class="mt-3">
                                            <label class="form-label">Current Images</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($product->images as $image)
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image) }}" 
                                                             alt="Product Image" 
                                                             class="img-thumbnail" 
                                                             style="width: 100px; height: 100px; object-fit: cover;">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                                onclick="removeImage('{{ $image }}')"
                                                                title="Remove Image">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div id="imagePreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                                </div>

                                <!-- Additional Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode" class="form-label">Barcode</label>
                                            <input type="text" 
                                                   class="form-control @error('barcode') is-invalid @enderror" 
                                                   id="barcode" 
                                                   name="barcode" 
                                                   value="{{ old('barcode', $product->barcode) }}" 
                                                   maxlength="100"
                                                   placeholder="Enter barcode">
                                            @error('barcode')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="expiry_date" class="form-label">Expiry Date</label>
                                            <input type="date" 
                                                   class="form-control @error('expiry_date') is-invalid @enderror" 
                                                   id="expiry_date" 
                                                   name="expiry_date" 
                                                   value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}">
                                            @error('expiry_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Leave empty if product doesn't expire
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Status -->
                                <div class="mb-3">
                                    <label class="form-label">Product Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Product
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Active products are visible and can be sold
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                        <i class="fas fa-undo me-2"></i>Reset Changes
                                    </button>
                                    <div>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>Update Product
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Product Preview -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-eye me-2"></i>Product Preview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="productPreview">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-box fa-3x text-primary"></i>
                                        </div>
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text text-muted">{{ $product->category->name ?? 'No Category' }}</p>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <small class="text-muted">Price</small><br>
                                                <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Stock</small><br>
                                                <strong class="text-info">{{ $product->quantity }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Product Info -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Current Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Created:</small><br>
                                    <strong>{{ $product->created_at->format('M j, Y') }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Updated:</small><br>
                                    <strong>{{ $product->updated_at->format('M j, Y') }}</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">SKU:</small><br>
                                    <code>{{ $product->sku }}</code>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Status:</small><br>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-info" onclick="calculateProfit()">
                                    <i class="fas fa-calculator me-2"></i>Calculate Profit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="previewProduct()">
                                    <i class="fas fa-eye me-2"></i>Preview Changes
                                </button>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>View Product
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editProductForm');
    const nameInput = document.getElementById('name');
    const priceInput = document.getElementById('price');
    const quantityInput = document.getElementById('quantity');
    const imagesInput = document.getElementById('images');

    // Image preview
    imagesInput.addEventListener('change', function() {
        previewImages(this.files);
    });

    // Real-time product preview
    [nameInput, priceInput, quantityInput].forEach(input => {
        input.addEventListener('input', updateProductPreview);
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });

    // Character counters
    setupCharacterCounters();

    // Track form changes
    trackFormChanges();
});

// Preview uploaded images
function previewImages(files) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    Array.from(files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.title = file.name;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
}

// Update product preview
function updateProductPreview() {
    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;
    const quantity = document.getElementById('quantity').value;
    const category = document.getElementById('category_id');
    const categoryText = category.options[category.selectedIndex]?.text || 'No Category';

    const preview = document.getElementById('productPreview');
    
    if (name) {
        preview.innerHTML = `
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-box fa-3x text-primary"></i>
                    </div>
                    <h6 class="card-title">${name}</h6>
                    <p class="card-text text-muted">${categoryText}</p>
                    <div class="row text-center">
                        <div class="col-6">
                            <small class="text-muted">Price</small><br>
                            <strong class="text-success">$${price || '0.00'}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Stock</small><br>
                            <strong class="text-info">${quantity || '0'}</strong>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

// Calculate profit margin
function calculateProfit() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const cost = parseFloat(document.getElementById('cost_price').value) || 0;
    
    if (price === 0) {
        alert('Please enter a selling price first');
        return;
    }
    
    if (cost === 0) {
        alert('Please enter a cost price first');
        return;
    }
    
    const profit = price - cost;
    const margin = ((profit / price) * 100).toFixed(2);
    
    alert(`Profit Calculation:\n\n` +
          `Selling Price: $${price.toFixed(2)}\n` +
          `Cost Price: $${cost.toFixed(2)}\n` +
          `Profit: $${profit.toFixed(2)}\n` +
          `Profit Margin: ${margin}%`);
}

// Preview product changes
function previewProduct() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const category = document.getElementById('category_id');
    const categoryText = category.options[category.selectedIndex]?.text || 'No Category';
    
    if (!name) {
        alert('Please enter a product name to preview');
        return;
    }
    
    const preview = `
        Product: ${name}
        Category: ${categoryText}
        Price: $${price || '0.00'}
        Description: ${description || 'No description'}
    `;
    
    alert('Product Preview:\n\n' + preview);
}

// Remove image
function removeImage(imagePath) {
    if (confirm('Are you sure you want to remove this image?')) {
        // Add hidden input to track removed images
        const form = document.getElementById('editProductForm');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_images[]';
        input.value = imagePath;
        form.appendChild(input);
        
        // Remove the image element from DOM
        event.target.closest('.position-relative').remove();
    }
}

// Validate form
function validateForm() {
    let isValid = true;
    const requiredFields = ['name', 'sku', 'category_id', 'price', 'quantity'];
    
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Validate price
    const price = parseFloat(document.getElementById('price').value);
    if (price < 0) {
        document.getElementById('price').classList.add('is-invalid');
        isValid = false;
    }

    // Validate quantity
    const quantity = parseInt(document.getElementById('quantity').value);
    if (quantity < 0) {
        document.getElementById('quantity').classList.add('is-invalid');
        isValid = false;
    }

    return isValid;
}

// Setup character counters
function setupCharacterCounters() {
    const fields = [
        { input: 'name', max: 255, counter: 'nameCounter' },
        { input: 'description', max: 1000, counter: 'descriptionCounter' },
        { input: 'brand', max: 100, counter: 'brandCounter' },
        { input: 'model', max: 100, counter: 'modelCounter' },
        { input: 'barcode', max: 100, counter: 'barcodeCounter' }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.input);
        if (input) {
            // Create counter element
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            counter.id = field.counter;
            input.parentNode.appendChild(counter);

            // Update counter on input
            input.addEventListener('input', function() {
                updateCounter(this, field.max, counter);
            });

            // Initial counter update
            updateCounter(input, field.max, counter);
        }
    });
}

// Update character counter
function updateCounter(input, max, counter) {
    const current = input.value.length;
    const remaining = max - current;
    const color = remaining < 10 ? 'text-danger' : remaining < 20 ? 'text-warning' : 'text-muted';
    
    counter.innerHTML = `<span class="${color}">${current}/${max}</span>`;
}

// Track form changes
function trackFormChanges() {
    const form = document.getElementById('editProductForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    let hasChanges = false;

    // Check for changes on any input
    form.addEventListener('input', function() {
        hasChanges = true;
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Product *';
        submitBtn.classList.add('btn-warning');
    });

    // Reset change tracking on form submission
    form.addEventListener('submit', function() {
        hasChanges = false;
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Product';
        submitBtn.classList.remove('btn-warning');
    });

    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });
}

// Reset form to original values
function resetForm() {
    if (confirm('Are you sure you want to reset all changes? All modifications will be lost.')) {
        // Reload the page to restore original values
        window.location.reload();
    }
}
</script>
@endpush

@push('styles')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.form-text {
    font-size: 0.875rem;
}

.btn {
    border-radius: 0.375rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

#productPreview .card {
    border: 2px dashed #dee2e6;
    background-color: #f8f9fa;
}

#productPreview .card:hover {
    border-color: #007bff;
    background-color: #e7f3ff;
}

.position-relative {
    position: relative;
}

.position-absolute {
    position: absolute;
}

.top-0 {
    top: 0;
}

.end-0 {
    right: 0;
}

code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}
</style>
@endpush