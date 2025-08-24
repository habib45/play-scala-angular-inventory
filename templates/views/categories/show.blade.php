@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>

            <!-- Category Header Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">
                            <i class="fas fa-tag me-2"></i>{{ $category->name }}
                        </h4>
                        <small class="text-muted">Category ID: {{ $category->id }}</small>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Category Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Name:</strong></td>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $category->description ?: 'No description provided' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Products Count:</strong></td>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $category->products_count ?? 0 }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $category->created_at->format('F j, Y \a\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $category->updated_at->format('F j, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.create') }}?category_id={{ $category->id }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add Product to Category
                                </a>
                                <a href="{{ route('products.index') }}?category_id={{ $category->id }}" class="btn btn-primary">
                                    <i class="fas fa-list me-2"></i>View All Products
                                </a>
                                <button type="button" class="btn btn-outline-info" onclick="exportCategoryData()">
                                    <i class="fas fa-download me-2"></i>Export Category Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in Category -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-boxes me-2"></i>Products in Category
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="productSearch" placeholder="Search products...">
                        </div>
                        <select class="form-select" id="stockFilter" style="width: 150px;">
                            <option value="">All Stock</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @if($category->products && $category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="productsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="productsTableBody">
                                    @foreach($category->products as $product)
                                        <tr data-product-id="{{ $product->id }}">
                                            <td>
                                                <code>{{ $product->sku }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                @if($product->description)
                                                    <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($product->price, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $product->quantity }}</span>
                                            </td>
                                            <td>
                                                @if($product->quantity > 10)
                                                    <span class="badge bg-success">In Stock</span>
                                                @elseif($product->quantity > 0)
                                                    <span class="badge bg-warning">Low Stock</span>
                                                @else
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->updated_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-info" onclick="viewProductHistory({{ $product->id }})" title="History">
                                                        <i class="fas fa-history"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Products Summary -->
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $category->products->where('quantity', '>', 10)->count() }}</h5>
                                        <p class="card-text">In Stock</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $category->products->where('quantity', '>', 0)->where('quantity', '<=', 10)->count() }}</h5>
                                        <p class="card-text">Low Stock</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $category->products->where('quantity', 0)->count() }}</h5>
                                        <p class="card-text">Out of Stock</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">${{ number_format($category->products->sum('price'), 2) }}</h5>
                                        <p class="card-text">Total Value</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-box-open fa-3x mb-3"></i>
                            <h5>No Products in Category</h5>
                            <p>This category doesn't have any products yet.</p>
                            <a href="{{ route('products.create') }}?category_id={{ $category->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Category Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Category Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Stock Overview</h6>
                            <canvas id="stockChart" width="400" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h6>Price Distribution</h6>
                            <canvas id="priceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
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
                <p>Are you sure you want to delete the category "<strong>{{ $category->name }}</strong>"?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. If the category has associated products, deletion will be prevented.
                </div>
                @if($category->products && $category->products->count() > 0)
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Cannot Delete:</strong> This category has {{ $category->products->count() }} associated product(s).
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                @if($category->products && $category->products->count() > 0)
                    <button type="button" class="btn btn-danger" disabled>
                        <i class="fas fa-trash me-2"></i>Cannot Delete (Has Products)
                    </button>
                @else
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete Category
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Product History Modal -->
<div class="modal fade" id="productHistoryModal" tabindex="-1" aria-labelledby="productHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productHistoryModalLabel">
                    <i class="fas fa-history me-2"></i>Product History
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productHistoryContent">
                    <!-- Product history will be loaded here -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let products = @json($category->products);
    let filteredProducts = [...products];

    // Initialize charts
    initializeCharts();

    // Event listeners
    document.getElementById('productSearch').addEventListener('input', handleProductSearch);
    document.getElementById('stockFilter').addEventListener('change', handleStockFilter);

    // Handle product search
    function handleProductSearch() {
        const searchTerm = document.getElementById('productSearch').value.toLowerCase();
        const stockFilter = document.getElementById('stockFilter').value;
        
        filteredProducts = products.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                                product.sku.toLowerCase().includes(searchTerm) ||
                                (product.description && product.description.toLowerCase().includes(searchTerm));
            
            const matchesStock = !stockFilter || 
                (stockFilter === 'in_stock' && product.quantity > 10) ||
                (stockFilter === 'low_stock' && product.quantity > 0 && product.quantity <= 10) ||
                (stockFilter === 'out_of_stock' && product.quantity === 0);
            
            return matchesSearch && matchesStock;
        });
        
        displayFilteredProducts();
    }

    // Handle stock filter
    function handleStockFilter() {
        handleProductSearch(); // This will apply both search and filter
    }

    // Display filtered products
    function displayFilteredProducts() {
        const tbody = document.getElementById('productsTableBody');
        tbody.innerHTML = '';

        if (filteredProducts.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <p>No products match your search criteria</p>
                    </td>
                </tr>
            `;
            return;
        }

        filteredProducts.forEach(product => {
            const row = document.createElement('tr');
            row.setAttribute('data-product-id', product.id);
            
            const stockStatus = product.quantity > 10 ? 
                '<span class="badge bg-success">In Stock</span>' :
                product.quantity > 0 ? 
                '<span class="badge bg-warning">Low Stock</span>' :
                '<span class="badge bg-danger">Out of Stock</span>';

            row.innerHTML = `
                <td><code>${product.sku}</code></td>
                <td>
                    <strong>${product.name}</strong>
                    ${product.description ? `<br><small class="text-muted">${product.description.substring(0, 50)}${product.description.length > 50 ? '...' : ''}</small>` : ''}
                </td>
                <td><span class="fw-bold text-success">$${parseFloat(product.price).toFixed(2)}</span></td>
                <td><span class="fw-bold">${product.quantity}</span></td>
                <td>${stockStatus}</td>
                <td>${new Date(product.updated_at).toLocaleDateString()}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="/products/${product.id}" class="btn btn-outline-primary" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/products/${product.id}/edit" class="btn btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="viewProductHistory(${product.id})" title="History">
                            <i class="fas fa-history"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Initialize charts
    function initializeCharts() {
        // Stock Chart
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        const stockChart = new Chart(stockCtx, {
            type: 'doughnut',
            data: {
                labels: ['In Stock (>10)', 'Low Stock (1-10)', 'Out of Stock (0)'],
                datasets: [{
                    data: [
                        products.filter(p => p.quantity > 10).length,
                        products.filter(p => p.quantity > 0 && p.quantity <= 10).length,
                        products.filter(p => p.quantity === 0).length
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Price Distribution Chart
        const priceCtx = document.getElementById('priceChart').getContext('2d');
        const priceRanges = [
            'Under $10',
            '$10 - $25',
            '$25 - $50',
            '$50 - $100',
            'Over $100'
        ];
        
        const priceData = [
            products.filter(p => p.price < 10).length,
            products.filter(p => p.price >= 10 && p.price < 25).length,
            products.filter(p => p.price >= 25 && p.price < 50).length,
            products.filter(p => p.price >= 50 && p.price < 100).length,
            products.filter(p => p.price >= 100).length
        ];

        const priceChart = new Chart(priceCtx, {
            type: 'bar',
            data: {
                labels: priceRanges,
                datasets: [{
                    label: 'Number of Products',
                    data: priceData,
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});

// Global functions
function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
}

function exportCategoryData() {
    // Implementation for exporting category data
    alert('Export functionality will be implemented here');
}

function viewProductHistory(productId) {
    // Load product history
    const modal = new bootstrap.Modal(document.getElementById('productHistoryModal'));
    const content = document.getElementById('productHistoryContent');
    
    content.innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading product history...</p>
        </div>
    `;
    
    modal.show();
    
    // Here you would typically make an API call to get product history
    // For now, we'll show a placeholder
    setTimeout(() => {
        content.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Product history feature will be implemented in future updates.
            </div>
        `;
    }, 1000);
}
</script>
@endpush