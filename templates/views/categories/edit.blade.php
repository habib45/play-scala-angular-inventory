@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Category
                    </h2>
                    <p class="text-muted mb-0">Update category information for "{{ $category->name }}"</p>
                </div>
                <div class="btn-group" role="group">
                    <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Category
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Categories
                    </a>
                </div>
            </div>

            <!-- Edit Category Form -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tag me-2"></i>Category Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('categories.update', $category) }}" method="POST" id="editCategoryForm">
                                @csrf
                                @method('PUT')
                                
                                <!-- Category Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Category Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $category->name) }}" 
                                           required 
                                           maxlength="255"
                                           placeholder="Enter category name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Choose a descriptive name that clearly identifies this category.
                                    </div>
                                </div>

                                <!-- Category Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              maxlength="500"
                                              placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Provide additional details about this category. Maximum 500 characters.
                                    </div>
                                </div>

                                <!-- Category Color (Optional) -->
                                <div class="mb-3">
                                    <label for="color" class="form-label">Category Color</label>
                                    <div class="input-group">
                                        <input type="color" 
                                               class="form-control form-control-color @error('color') is-invalid @enderror" 
                                               id="color" 
                                               name="color" 
                                               value="{{ old('color', $category->color ?? '#007bff') }}"
                                               title="Choose a color for this category">
                                        <span class="input-group-text">
                                            <i class="fas fa-palette"></i>
                                        </span>
                                    </div>
                                    @error('color')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Choose a color to help visually distinguish this category.
                                    </div>
                                </div>

                                <!-- Category Icon (Optional) -->
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Category Icon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-icons"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control @error('icon') is-invalid @enderror" 
                                               id="icon" 
                                               name="icon" 
                                               value="{{ old('icon', $category->icon ?? 'fas fa-tag') }}"
                                               placeholder="fas fa-tag"
                                               maxlength="50">
                                    </div>
                                    @error('icon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Enter a FontAwesome icon class (e.g., fas fa-tag, fas fa-pills).
                                    </div>
                                </div>

                                <!-- Parent Category (Optional) -->
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent Category</label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror" 
                                            id="parent_id" 
                                            name="parent_id">
                                        <option value="">No Parent Category</option>
                                        @foreach($categories ?? [] as $cat)
                                            @if($cat->id !== $category->id)
                                                <option value="{{ $cat->id }}" 
                                                        {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        Select a parent category if this is a subcategory. Cannot select itself.
                                    </div>
                                </div>

                                <!-- Category Status -->
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Category
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Active categories are visible and can contain products.
                                    </div>
                                </div>

                                <!-- SEO Fields -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-search me-2"></i>SEO Information (Optional)
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" 
                                                   class="form-control @error('meta_title') is-invalid @enderror" 
                                                   id="meta_title" 
                                                   name="meta_title" 
                                                   value="{{ old('meta_title', $category->meta_title) }}"
                                                   maxlength="60"
                                                   placeholder="Enter meta title for SEO">
                                            @error('meta_title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Title for search engines. Recommended length: 50-60 characters.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                      id="meta_description" 
                                                      name="meta_description" 
                                                      rows="3" 
                                                      maxlength="160"
                                                      placeholder="Enter meta description for SEO">{{ old('meta_description', $category->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                Description for search engines. Recommended length: 150-160 characters.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="slug" class="form-label">URL Slug</label>
                                            <input type="text" 
                                                   class="form-control @error('slug') is-invalid @enderror" 
                                                   id="slug" 
                                                   name="slug" 
                                                   value="{{ old('slug', $category->slug) }}"
                                                   maxlength="100"
                                                   placeholder="auto-generated-slug">
                                            @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="form-text">
                                                URL-friendly version of the category name. Leave empty for auto-generation.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Category Info -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Current Category Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">Created:</small><br>
                                                <strong>{{ $category->created_at->format('F j, Y \a\t g:i A') }}</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Last Updated:</small><br>
                                                <strong>{{ $category->updated_at->format('F j, Y \a\t g:i A') }}</strong>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">Products Count:</small><br>
                                                <span class="badge bg-info fs-6">{{ $category->products_count ?? 0 }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Category ID:</small><br>
                                                <code>{{ $category->id }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                        <i class="fas fa-undo me-2"></i>Reset Changes
                                    </button>
                                    <div>
                                        <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary me-2">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save me-2"></i>Update Category
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>Editing Categories
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> Changes to category names may affect product organization and search functionality.
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Best Practices:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Test changes in staging first</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Update related documentation</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Notify team members of changes</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Review SEO impact</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Considerations:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Product associations</li>
                                        <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>URL changes</li>
                                        <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>Search indexing</li>
                                        <li><i class="fas fa-exclamation-triangle text-warning me-2"></i>User bookmarks</li>
                                    </ul>
                                </div>
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
    const form = document.getElementById('editCategoryForm');
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const metaTitleInput = document.getElementById('meta_title');
    const metaDescriptionInput = document.getElementById('description');
    const originalData = {
        name: '{{ $category->name }}',
        description: '{{ $category->description ?? "" }}',
        color: '{{ $category->color ?? "#007bff" }}',
        icon: '{{ $category->icon ?? "fas fa-tag" }}',
        parent_id: '{{ $category->parent_id ?? "" }}',
        is_active: {{ $category->is_active ?? true ? 'true' : 'false' }},
        meta_title: '{{ $category->meta_title ?? "" }}',
        meta_description: '{{ $category->meta_description ?? "" }}',
        slug: '{{ $category->slug ?? "" }}'
    };

    // Auto-generate slug from name
    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
            const slug = generateSlug(this.value);
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    // Auto-generate meta title from name
    nameInput.addEventListener('input', function() {
        if (!metaTitleInput.value || metaTitleInput.dataset.autoGenerated === 'true') {
            metaTitleInput.value = this.value;
            metaTitleInput.dataset.autoGenerated = 'true';
        }
    });

    // Auto-generate meta description from description
    document.getElementById('description').addEventListener('input', function() {
        if (!metaDescriptionInput.value || metaDescriptionInput.dataset.autoGenerated === 'true') {
            const description = this.value.substring(0, 160);
            metaDescriptionInput.value = description;
            metaDescriptionInput.dataset.autoGenerated = 'true';
        }
    });

    // Manual slug input clears auto-generated flag
    slugInput.addEventListener('input', function() {
        if (this.dataset.autoGenerated === 'true') {
            this.dataset.autoGenerated = 'false';
        }
    });

    // Manual meta title input clears auto-generated flag
    metaTitleInput.addEventListener('input', function() {
        if (this.dataset.autoGenerated === 'true') {
            this.dataset.autoGenerated = 'false';
        }
    });

    // Manual meta description input clears auto-generated flag
    metaDescriptionInput.addEventListener('input', function() {
        if (this.dataset.autoGenerated === 'true') {
            this.dataset.autoGenerated = 'false';
        }
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

// Generate URL-friendly slug
function generateSlug(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
        .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
}

// Validate form
function validateForm() {
    let isValid = true;
    const requiredFields = ['name'];
    
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Validate meta title length
    const metaTitle = document.getElementById('meta_title');
    if (metaTitle.value && metaTitle.value.length > 60) {
        metaTitle.classList.add('is-invalid');
        isValid = false;
    }

    // Validate meta description length
    const metaDescription = document.getElementById('meta_description');
    if (metaDescription.value && metaDescription.value.length > 160) {
        metaDescription.classList.add('is-invalid');
        isValid = false;
    }

    return isValid;
}

// Setup character counters
function setupCharacterCounters() {
    const fields = [
        { input: 'name', max: 255, counter: 'nameCounter' },
        { input: 'description', max: 500, counter: 'descriptionCounter' },
        { input: 'meta_title', max: 60, counter: 'metaTitleCounter' },
        { input: 'meta_description', max: 160, counter: 'metaDescriptionCounter' },
        { input: 'slug', max: 100, counter: 'slugCounter' }
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
    const form = document.getElementById('editCategoryForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    let hasChanges = false;

    // Check for changes on any input
    form.addEventListener('input', function() {
        hasChanges = true;
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Category *';
        submitBtn.classList.add('btn-warning');
    });

    // Reset change tracking on form submission
    form.addEventListener('submit', function() {
        hasChanges = false;
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Category';
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
        const form = document.getElementById('editCategoryForm');
        
        // Reset to original values
        document.getElementById('name').value = '{{ $category->name }}';
        document.getElementById('description').value = '{{ $category->description ?? "" }}';
        document.getElementById('color').value = '{{ $category->color ?? "#007bff" }}';
        document.getElementById('icon').value = '{{ $category->icon ?? "fas fa-tag" }}';
        document.getElementById('parent_id').value = '{{ $category->parent_id ?? "" }}';
        document.getElementById('is_active').checked = {{ $category->is_active ?? true ? 'true' : 'false' }};
        document.getElementById('meta_title').value = '{{ $category->meta_title ?? "" }}';
        document.getElementById('meta_description').value = '{{ $category->meta_description ?? "" }}';
        document.getElementById('slug').value = '{{ $category->slug ?? "" }}';
        
        // Clear auto-generated flags
        document.getElementById('slug').dataset.autoGenerated = 'false';
        document.getElementById('meta_title').dataset.autoGenerated = 'false';
        document.getElementById('meta_description').dataset.autoGenerated = 'false';
        
        // Reset character counters
        setupCharacterCounters();
        
        // Clear validation states
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Reset change tracking
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Category';
        submitBtn.classList.remove('btn-warning');
    }
}

// Preview category changes
function previewCategory() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const color = document.getElementById('color').value;
    const icon = document.getElementById('icon').value || 'fas fa-tag';
    
    if (!name) {
        alert('Please enter a category name to preview.');
        return;
    }

    const previewHtml = `
        <div class="card" style="border-left: 4px solid ${color};">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="${icon}" style="color: ${color};"></i>
                    ${name}
                </h5>
                <p class="card-text">${description || 'No description provided'}</p>
                <span class="badge bg-info">{{ $category->products_count ?? 0 }} products</span>
            </div>
        </div>
    `;

    // Show preview in modal or alert
    alert('Category Preview:\n\n' + 
          'Name: ' + name + '\n' +
          'Description: ' + (description || 'No description') + '\n' +
          'Color: ' + color + '\n' +
          'Icon: ' + icon + '\n' +
          'Products: {{ $category->products_count ?? 0 }}');
}
</script>
@endpush

@push('styles')
<style>
.form-control-color {
    width: 60px;
    height: 38px;
    padding: 0;
    border: 1px solid #ced4da;
}

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

.alert {
    border-radius: 0.375rem;
}

code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}
</style>
@endpush