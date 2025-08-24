@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>Categories
                    </h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="fas fa-plus me-2"></i>Add Category
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search categories...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="categoriesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Products Count</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Categories will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> categories
                        </div>
                        <nav aria-label="Categories pagination">
                            <ul class="pagination mb-0" id="pagination">
                                <!-- Pagination will be generated here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">
                    <i class="fas fa-plus me-2"></i>Create New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCategoryForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required maxlength="255">
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="descriptionError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm">
                <input type="hidden" id="editCategoryId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required maxlength="255">
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editCategoryDescription" name="description" rows="3" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="editDescriptionError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category "<strong id="deleteCategoryName"></strong>"?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. If the category has associated products, deletion will be prevented.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Delete Category
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Category Details Modal -->
<div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCategoryModalLabel">
                    <i class="fas fa-eye me-2"></i>Category Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Category Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td id="viewCategoryId"></td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td id="viewCategoryName"></td>
                            </tr>
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td id="viewCategoryDescription"></td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td id="viewCategoryCreated"></td>
                            </tr>
                            <tr>
                                <td><strong>Updated:</strong></td>
                                <td id="viewCategoryUpdated"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Products in Category</h6>
                        <div id="categoryProductsList">
                            <!-- Products will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let searchTerm = '';
    let categories = [];

    // Initialize the page
    loadCategories();

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(handleSearch, 300));
    document.getElementById('refreshBtn').addEventListener('click', loadCategories);
    document.getElementById('createCategoryForm').addEventListener('submit', handleCreateCategory);
    document.getElementById('editCategoryForm').addEventListener('submit', handleEditCategory);
    document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeleteCategory);

    // Load categories from API
    async function loadCategories() {
        try {
            showLoading();
            const response = await fetch('/api/v1/categories');
            if (response.ok) {
                const data = await response.json();
                categories = data.data;
                displayCategories();
                updatePagination();
            } else {
                showError('Failed to load categories');
            }
        } catch (error) {
            showError('Error loading categories: ' + error.message);
        } finally {
            hideLoading();
        }
    }

    // Display categories in table
    function displayCategories() {
        const tbody = document.getElementById('categoriesTableBody');
        tbody.innerHTML = '';

        if (categories.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-3"></i>
                        <p>No categories found</p>
                    </td>
                </tr>
            `;
            return;
        }

        categories.forEach(category => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${category.id}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(category.name)}</span>
                </td>
                <td>${escapeHtml(category.description || 'No description')}</td>
                <td>
                    <span class="badge bg-info">${category.products_count || 0}</span>
                </td>
                <td>${formatDate(category.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewCategory(${category.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editCategory(${category.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteCategory(${category.id}, '${escapeHtml(category.name)}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle search
    function handleSearch() {
        searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const filteredCategories = categories.filter(category => 
            category.name.toLowerCase().includes(searchTerm) ||
            (category.description && category.description.toLowerCase().includes(searchTerm))
        );
        displayFilteredCategories(filteredCategories);
    }

    // Display filtered categories
    function displayFilteredCategories(filteredCategories) {
        const tbody = document.getElementById('categoriesTableBody');
        tbody.innerHTML = '';

        if (filteredCategories.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <p>No categories match your search</p>
                    </td>
                </tr>
            `;
            return;
        }

        filteredCategories.forEach(category => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${category.id}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(category.name)}</span>
                </td>
                <td>${escapeHtml(category.description || 'No description')}</td>
                <td>
                    <span class="badge bg-info">${category.products_count || 0}</span>
                </td>
                <td>${formatDate(category.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewCategory(${category.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editCategory(${category.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteCategory(${category.id}, '${escapeHtml(category.name)}')" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle create category
    async function handleCreateCategory(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const categoryData = {
            name: formData.get('name'),
            description: formData.get('description')
        };

        try {
            const response = await fetch('/api/v1/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(categoryData)
            });

            if (response.ok) {
                showSuccess('Category created successfully');
                bootstrap.Modal.getInstance(document.getElementById('createCategoryModal')).hide();
                e.target.reset();
                loadCategories();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors);
            }
        } catch (error) {
            showError('Error creating category: ' + error.message);
        }
    }

    // Handle edit category
    async function handleEditCategory(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const categoryId = formData.get('id');
        const categoryData = {
            name: formData.get('name'),
            description: formData.get('description')
        };

        try {
            const response = await fetch(`/api/v1/categories/${categoryId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(categoryData)
            });

            if (response.ok) {
                showSuccess('Category updated successfully');
                bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide();
                loadCategories();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors, 'edit');
            }
        } catch (error) {
            showError('Error updating category: ' + error.message);
        }
    }

    // Handle delete category
    async function handleDeleteCategory() {
        const categoryId = document.getElementById('confirmDeleteBtn').getAttribute('data-category-id');
        
        try {
            const response = await fetch(`/api/v1/categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                showSuccess('Category deleted successfully');
                bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal')).hide();
                loadCategories();
            } else {
                const errorData = await response.json();
                showError(errorData.message || 'Failed to delete category');
            }
        } catch (error) {
            showError('Error deleting category: ' + error.message);
        }
    }

    // Utility functions
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        return new Date(dateString).toLocaleDateString();
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function showLoading() {
        // Add loading indicator
    }

    function hideLoading() {
        // Remove loading indicator
    }

    function showSuccess(message) {
        // Show success message
        alert(message); // Replace with proper toast notification
    }

    function showError(message) {
        // Show error message
        alert('Error: ' + message); // Replace with proper toast notification
    }

    function showValidationErrors(errors, prefix = '') {
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        // Show new errors
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(prefix + field.charAt(0).toUpperCase() + field.slice(1));
            const errorDiv = document.getElementById(prefix + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
            
            if (input && errorDiv) {
                input.classList.add('is-invalid');
                errorDiv.textContent = errors[field][0];
            }
        });
    }

    function updatePagination() {
        // Update pagination info
        const total = categories.length;
        document.getElementById('totalRecords').textContent = total;
        document.getElementById('showingStart').textContent = total > 0 ? 1 : 0;
        document.getElementById('showingEnd').textContent = total;
    }
});

// Global functions for modal actions
function viewCategory(categoryId) {
    const category = categories.find(c => c.id === categoryId);
    if (category) {
        document.getElementById('viewCategoryId').textContent = category.id;
        document.getElementById('viewCategoryName').textContent = category.name;
        document.getElementById('viewCategoryDescription').textContent = category.description || 'No description';
        document.getElementById('viewCategoryCreated').textContent = formatDate(category.created_at);
        document.getElementById('viewCategoryUpdated').textContent = formatDate(category.updated_at);
        
        // Load products for this category
        loadCategoryProducts(categoryId);
        
        new bootstrap.Modal(document.getElementById('viewCategoryModal')).show();
    }
}

function editCategory(categoryId) {
    const category = categories.find(c => c.id === categoryId);
    if (category) {
        document.getElementById('editCategoryId').value = category.id;
        document.getElementById('editCategoryName').value = category.name;
        document.getElementById('editCategoryDescription').value = category.description || '';
        
        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }
}

function deleteCategory(categoryId, categoryName) {
    document.getElementById('deleteCategoryName').textContent = categoryName;
    document.getElementById('confirmDeleteBtn').setAttribute('data-category-id', categoryId);
    
    new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
}

async function loadCategoryProducts(categoryId) {
    try {
        const response = await fetch(`/api/v1/products?category_id=${categoryId}`);
        if (response.ok) {
            const data = await response.json();
            const productsList = document.getElementById('categoryProductsList');
            
            if (data.data && data.data.length > 0) {
                let productsHtml = '<ul class="list-group list-group-flush">';
                data.data.forEach(product => {
                    productsHtml += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${product.name}</strong>
                                <br><small class="text-muted">SKU: ${product.sku}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">${product.quantity}</span>
                        </li>
                    `;
                });
                productsHtml += '</ul>';
                productsList.innerHTML = productsHtml;
            } else {
                productsList.innerHTML = '<p class="text-muted">No products in this category</p>';
            }
        }
    } catch (error) {
        document.getElementById('categoryProductsList').innerHTML = '<p class="text-danger">Error loading products</p>';
    }
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush