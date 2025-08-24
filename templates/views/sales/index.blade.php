@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-cash-register me-2"></i>Sales
                    </h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSaleModal">
                        <i class="fas fa-plus me-2"></i>New Sale
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search sales...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="customerFilter">
                                <option value="">All Customers</option>
                                <option value="walk-in">Walk-in Customer</option>
                                <option value="registered">Registered Customer</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Sales Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="salesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="salesTableBody">
                                <!-- Sales will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> sales
                        </div>
                        <nav aria-label="Sales pagination">
                            <ul class="pagination mb-0" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Sale Modal -->
<div class="modal fade" id="createSaleModal" tabindex="-1" aria-labelledby="createSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSaleModalLabel">
                    <i class="fas fa-plus me-2"></i>Create New Sale
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createSaleForm">
                <div class="modal-body">
                    <!-- Sale Header -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="saleCustomer" class="form-label">Customer</label>
                                <input type="text" class="form-control" id="saleCustomer" name="customer_name" placeholder="Customer Name (Optional)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="saleDate" class="form-label">Sale Date *</label>
                                <input type="date" class="form-control" id="saleDate" name="date" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="mb-3">
                        <label class="form-label">Sale Items *</label>
                        <div id="saleItems">
                            <div class="sale-item border rounded p-3 mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label class="form-label">Product *</label>
                                            <select class="form-select product-select" name="items[0][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                                        {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->quantity }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label">Quantity *</label>
                                            <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label">Price *</label>
                                            <input type="number" class="form-control price-input" name="items[0][price]" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label">Total</label>
                                            <input type="text" class="form-control item-total" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm d-block remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addItemBtn">
                            <i class="fas fa-plus me-2"></i>Add Item
                        </button>
                    </div>

                    <!-- Sale Summary -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="saleNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="saleNotes" name="notes" rows="3" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Sale Summary</h6>
                                    <div class="row">
                                        <div class="col-6"><strong>Total Items:</strong></div>
                                        <div class="col-6" id="totalItems">0</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"><strong>Total Amount:</strong></div>
                                        <div class="col-6" id="totalAmount">$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Sale
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Sale Modal -->
<div class="modal fade" id="editSaleModal" tabindex="-1" aria-labelledby="editSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSaleModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Sale
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSaleForm">
                <input type="hidden" id="editSaleId" name="id">
                <div class="modal-body">
                    <!-- Sale Header -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSaleCustomer" class="form-label">Customer</label>
                                <input type="text" class="form-control" id="editSaleCustomer" name="customer_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSaleDate" class="form-label">Sale Date *</label>
                                <input type="date" class="form-control" id="editSaleDate" name="date" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="mb-3">
                        <label class="form-label">Sale Items *</label>
                        <div id="editSaleItems"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="editAddItemBtn">
                            <i class="fas fa-plus me-2"></i>Add Item
                        </button>
                    </div>

                    <!-- Sale Summary -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editSaleNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="editSaleNotes" name="notes" rows="3" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Sale Summary</h6>
                                    <div class="row">
                                        <div class="col-6"><strong>Total Items:</strong></div>
                                        <div class="col-6" id="editTotalItems">0</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"><strong>Total Amount:</strong></div>
                                        <div class="col-6" id="editTotalAmount">$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Update Sale
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSaleModal" tabindex="-1" aria-labelledby="deleteSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSaleModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the sale "<strong id="deleteSaleId"></strong>"?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. Deleting a sale will reverse stock updates.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Delete Sale
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Sale Details Modal -->
<div class="modal fade" id="viewSaleModal" tabindex="-1" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSaleModalLabel">
                    <i class="fas fa-eye me-2"></i>Sale Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Sale Information</h6>
                        <table class="table table-borderless">
                            <tr><td width="150"><strong>ID:</strong></td><td id="viewSaleId"></td></tr>
                            <tr><td><strong>Date:</strong></td><td id="viewSaleDate"></td></tr>
                            <tr><td><strong>Customer:</strong></td><td id="viewSaleCustomer"></td></tr>
                            <tr><td><strong>Total Amount:</strong></td><td id="viewSaleTotal"></td></tr>
                            <tr><td><strong>Status:</strong></td><td id="viewSaleStatus"></td></tr>
                            <tr><td><strong>Created:</strong></td><td id="viewSaleCreated"></td></tr>
                            <tr><td><strong>Updated:</strong></td><td id="viewSaleUpdated"></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Sale Items</h6>
                        <div id="viewSaleItems"></div>
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
    let sales = [];
    let itemCounter = 1;

    // Initialize the page
    loadSales();

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(handleSearch, 300));
    document.getElementById('customerFilter').addEventListener('change', handleFilter);
    document.getElementById('statusFilter').addEventListener('change', handleFilter);
    document.getElementById('refreshBtn').addEventListener('click', loadSales);
    document.getElementById('createSaleForm').addEventListener('submit', handleCreateSale);
    document.getElementById('editSaleForm').addEventListener('submit', handleEditSale);
    document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeleteSale);
    document.getElementById('addItemBtn').addEventListener('click', addSaleItem);
    document.getElementById('editAddItemBtn').addEventListener('click', addEditSaleItem);

    // Load sales from API
    async function loadSales() {
        try {
            showLoading();
            const response = await fetch('/api/v1/sales');
            if (response.ok) {
                const data = await response.json();
                sales = data.data;
                displaySales();
                updatePagination();
            } else {
                showError('Failed to load sales');
            }
        } catch (error) {
            showError('Error loading sales: ' + error.message);
        } finally {
            hideLoading();
        }
    }

    // Display sales in table
    function displaySales() {
        const tbody = document.getElementById('salesTableBody');
        tbody.innerHTML = '';

        if (sales.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-cash-register fa-2x mb-3"></i><p>No sales found</p>
                </td></tr>
            `;
            return;
        }

        sales.forEach(sale => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sale.id}</td>
                <td>${formatDate(sale.date)}</td>
                <td><span class="fw-bold">${escapeHtml(sale.customer_name || 'Walk-in Customer')}</span></td>
                <td><span class="badge bg-info">${sale.items?.length || 0} items</span></td>
                <td><span class="fw-bold text-success">$${parseFloat(sale.total_amount || 0).toFixed(2)}</span></td>
                <td><span class="badge bg-success">Completed</span></td>
                <td>${formatDate(sale.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewSale(${sale.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editSale(${sale.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSale(${sale.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle search and filtering
    function handleSearch() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const customerFilter = document.getElementById('customerFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        const filteredSales = sales.filter(sale => {
            const matchesSearch = sale.id.toString().includes(searchTerm) ||
                                (sale.customer_name && sale.customer_name.toLowerCase().includes(searchTerm));
            
            const matchesCustomer = !customerFilter || 
                (customerFilter === 'walk-in' && !sale.customer_name) ||
                (customerFilter === 'registered' && sale.customer_name);
            
            const matchesStatus = !statusFilter || sale.status === statusFilter;
            
            return matchesSearch && matchesCustomer && matchesStatus;
        });
        
        displayFilteredSales(filteredSales);
    }

    function handleFilter() {
        handleSearch();
    }

    // Display filtered sales
    function displayFilteredSales(filteredSales) {
        const tbody = document.getElementById('salesTableBody');
        tbody.innerHTML = '';

        if (filteredSales.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-search fa-2x mb-3"></i><p>No sales match your criteria</p>
                </td></tr>
            `;
            return;
        }

        filteredSales.forEach(sale => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sale.id}</td>
                <td>${formatDate(sale.date)}</td>
                <td><span class="fw-bold">${escapeHtml(sale.customer_name || 'Walk-in Customer')}</span></td>
                <td><span class="badge bg-info">${sale.items?.length || 0} items</span></td>
                <td><span class="fw-bold text-success">$${parseFloat(sale.total_amount || 0).toFixed(2)}</span></td>
                <td><span class="badge bg-success">Completed</span></td>
                <td>${formatDate(sale.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewSale(${sale.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editSale(${sale.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteSale(${sale.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle create sale
    async function handleCreateSale(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const saleData = {
            customer_name: formData.get('customer_name'),
            date: formData.get('date'),
            notes: formData.get('notes'),
            items: []
        };

        // Collect items data
        const itemElements = document.querySelectorAll('#saleItems .sale-item');
        itemElements.forEach((item, index) => {
            const productId = item.querySelector('.product-select').value;
            const quantity = item.querySelector('.quantity-input').value;
            const price = item.querySelector('.price-input').value;
            
            if (productId && quantity && price) {
                saleData.items.push({
                    product_id: productId,
                    quantity: parseInt(quantity),
                    price: parseFloat(price)
                });
            }
        });

        if (saleData.items.length === 0) {
            showError('Please add at least one item to the sale');
            return;
        }

        try {
            const response = await fetch('/api/v1/sales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(saleData)
            });

            if (response.ok) {
                showSuccess('Sale created successfully');
                bootstrap.Modal.getInstance(document.getElementById('createSaleModal')).hide();
                e.target.reset();
                resetSaleForm();
                loadSales();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors);
            }
        } catch (error) {
            showError('Error creating sale: ' + error.message);
        }
    }

    // Handle edit sale
    async function handleEditSale(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const saleId = formData.get('id');
        const saleData = {
            customer_name: formData.get('customer_name'),
            date: formData.get('date'),
            notes: formData.get('notes'),
            items: []
        };

        // Collect items data
        const itemElements = document.querySelectorAll('#editSaleItems .sale-item');
        itemElements.forEach((item, index) => {
            const productId = item.querySelector('.product-select').value;
            const quantity = item.querySelector('.quantity-input').value;
            const price = item.querySelector('.price-input').value;
            
            if (productId && quantity && price) {
                saleData.items.push({
                    product_id: productId,
                    quantity: parseInt(quantity),
                    price: parseFloat(price)
                });
            }
        });

        if (saleData.items.length === 0) {
            showError('Please add at least one item to the sale');
            return;
        }

        try {
            const response = await fetch(`/api/v1/sales/${saleId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(saleData)
            });

            if (response.ok) {
                showSuccess('Sale updated successfully');
                bootstrap.Modal.getInstance(document.getElementById('editSaleModal')).hide();
                loadSales();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors, 'edit');
            }
        } catch (error) {
            showError('Error updating sale: ' + error.message);
        }
    }

    // Handle delete sale
    async function handleDeleteSale() {
        const saleId = document.getElementById('confirmDeleteBtn').getAttribute('data-sale-id');
        
        try {
            const response = await fetch(`/api/v1/sales/${saleId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                showSuccess('Sale deleted successfully');
                bootstrap.Modal.getInstance(document.getElementById('deleteSaleModal')).hide();
                loadSales();
            } else {
                const errorData = await response.json();
                showError(errorData.message || 'Failed to delete sale');
            }
        } catch (error) {
            showError('Error deleting sale: ' + error.message);
        }
    }

    // Add sale item
    function addSaleItem() {
        const itemsContainer = document.getElementById('saleItems');
        const newItem = document.createElement('div');
        newItem.className = 'sale-item border rounded p-3 mb-2';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product *</label>
                        <select class="form-select product-select" name="items[${itemCounter}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                    {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->quantity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Quantity *</label>
                        <input type="number" class="form-control quantity-input" name="items[${itemCounter}][quantity]" min="1" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Price *</label>
                        <input type="number" class="form-control price-input" name="items[${itemCounter}][price]" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Total</label>
                        <input type="text" class="form-control item-total" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        itemsContainer.appendChild(newItem);
        itemCounter++;
        setupItemEventListeners(newItem);
    }

    // Add edit sale item
    function addEditSaleItem() {
        const itemsContainer = document.getElementById('editSaleItems');
        const newItem = document.createElement('div');
        newItem.className = 'sale-item border rounded p-3 mb-2';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product *</label>
                        <select class="form-select product-select" name="items[${itemCounter}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                                    {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->quantity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Quantity *</label>
                        <input type="number" class="form-control quantity-input" name="items[${itemCounter}][quantity]" min="1" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Price *</label>
                        <input type="number" class="form-control price-input" name="items[${itemCounter}][price]" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">Total</label>
                        <input type="text" class="form-control item-total" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        itemsContainer.appendChild(newItem);
        itemCounter++;
        setupItemEventListeners(newItem);
    }

    // Setup item event listeners
    function setupItemEventListeners(item) {
        const productSelect = item.querySelector('.product-select');
        const quantityInput = item.querySelector('.quantity-input');
        const priceInput = item.querySelector('.price-input');

        // Product selection
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.price) {
                priceInput.value = selectedOption.dataset.price;
                calculateItemTotal(item);
            }
        });

        // Quantity and price changes
        quantityInput.addEventListener('input', () => calculateItemTotal(item));
        priceInput.addEventListener('input', () => calculateItemTotal(item));
    }

    // Calculate item total
    function calculateItemTotal(item) {
        const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(item.querySelector('.price-input').value) || 0;
        const total = quantity * price;
        
        item.querySelector('.item-total').value = total.toFixed(2);
        calculateSaleTotal();
    }

    // Calculate sale total
    function calculateSaleTotal() {
        const items = document.querySelectorAll('.sale-item');
        let totalItems = 0;
        let totalAmount = 0;

        items.forEach(item => {
            const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
            const total = parseFloat(item.querySelector('.item-total').value) || 0;
            
            if (quantity > 0) totalItems++;
            totalAmount += total;
        });

        // Update summary
        const totalItemsElement = document.getElementById('totalItems');
        const totalAmountElement = document.getElementById('totalAmount');
        
        if (totalItemsElement) totalItemsElement.textContent = totalItems;
        if (totalAmountElement) totalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;

        // Update edit summary if exists
        const editTotalItemsElement = document.getElementById('editTotalItems');
        const editTotalAmountElement = document.getElementById('editTotalAmount');
        
        if (editTotalItemsElement) editTotalItemsElement.textContent = totalItems;
        if (editTotalAmountElement) editTotalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;
    }

    // Reset sale form
    function resetSaleForm() {
        const itemsContainer = document.getElementById('saleItems');
        itemsContainer.innerHTML = '';
        itemCounter = 1;
        addSaleItem(); // Add one default item
        calculateSaleTotal();
    }

    // Setup initial event listeners
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.sale-item').remove();
            calculateSaleTotal();
        }
    });

    // Setup initial item
    setupItemEventListeners(document.querySelector('.sale-item'));

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

    function showLoading() {}
    function hideLoading() {}
    function showSuccess(message) { alert(message); }
    function showError(message) { alert('Error: ' + message); }
    function showValidationErrors(errors, prefix = '') {}
    function updatePagination() {
        const total = sales.length;
        document.getElementById('totalRecords').textContent = total;
        document.getElementById('showingStart').textContent = total > 0 ? 1 : 0;
        document.getElementById('showingEnd').textContent = total;
    }
});

// Global functions for modal actions
function viewSale(saleId) {
    const sale = sales.find(s => s.id === saleId);
    if (sale) {
        document.getElementById('viewSaleId').textContent = sale.id;
        document.getElementById('viewSaleDate').textContent = formatDate(sale.date);
        document.getElementById('viewSaleCustomer').textContent = sale.customer_name || 'Walk-in Customer';
        document.getElementById('viewSaleTotal').textContent = `$${parseFloat(sale.total_amount || 0).toFixed(2)}`;
        document.getElementById('viewSaleStatus').innerHTML = '<span class="badge bg-success">Completed</span>';
        document.getElementById('viewSaleCreated').textContent = formatDate(sale.created_at);
        document.getElementById('viewSaleUpdated').textContent = formatDate(sale.updated_at);
        
        loadSaleItems(sale);
        new bootstrap.Modal(document.getElementById('viewSaleModal')).show();
    }
}

function editSale(saleId) {
    const sale = sales.find(s => s.id === saleId);
    if (sale) {
        document.getElementById('editSaleId').value = sale.id;
        document.getElementById('editSaleCustomer').value = sale.customer_name || '';
        document.getElementById('editSaleDate').value = sale.date;
        document.getElementById('editSaleNotes').value = sale.notes || '';
        
        loadEditSaleItems(sale);
        new bootstrap.Modal(document.getElementById('editSaleModal')).show();
    }
}

function deleteSale(saleId) {
    document.getElementById('deleteSaleId').textContent = saleId;
    document.getElementById('confirmDeleteBtn').setAttribute('data-sale-id', saleId);
    new bootstrap.Modal(document.getElementById('deleteSaleModal')).show();
}

async function loadSaleItems(sale) {
    const itemsContainer = document.getElementById('viewSaleItems');
    
    if (sale.items && sale.items.length > 0) {
        let itemsHtml = '<div class="table-responsive"><table class="table table-sm">';
        itemsHtml += '<thead><tr><th>Product</th><th>SKU</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead><tbody>';
        
        sale.items.forEach(item => {
            itemsHtml += `
                <tr>
                    <td><strong>${item.product?.name || 'N/A'}</strong></td>
                    <td><code>${item.product?.sku || 'N/A'}</code></td>
                    <td><span class="badge bg-info">${item.quantity}</span></td>
                    <td>$${parseFloat(item.price).toFixed(2)}</td>
                    <td><strong>$${(item.quantity * item.price).toFixed(2)}</strong></td>
                </tr>
            `;
        });
        
        itemsHtml += '</tbody></table></div>';
        itemsContainer.innerHTML = itemsHtml;
    } else {
        itemsContainer.innerHTML = '<p class="text-muted">No items found</p>';
    }
}

async function loadEditSaleItems(sale) {
    const itemsContainer = document.getElementById('editSaleItems');
    itemsContainer.innerHTML = '';
    
    if (sale.items && sale.items.length > 0) {
        sale.items.forEach((item, index) => {
            const newItem = document.createElement('div');
            newItem.className = 'sale-item border rounded p-3 mb-2';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label">Product *</label>
                            <select class="form-select product-select" name="items[${index}][product_id]" required>
                                <option value="">Select Product</option>
                                @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}" ${item.product_id == {{ $product->id }} ? 'selected' : ''}>
                                        {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->quantity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-2">
                            <label class="form-label">Quantity *</label>
                            <input type="number" class="form-control quantity-input" name="items[${index}][quantity]" min="1" required value="${item.quantity}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-2">
                            <label class="form-label">Price *</label>
                            <input type="number" class="form-control price-input" name="items[${index}][price]" step="0.01" min="0" required value="${item.price}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-2">
                            <label class="form-label">Total</label>
                            <input type="text" class="form-control item-total" readonly value="${(item.quantity * item.price).toFixed(2)}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm d-block remove-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            itemsContainer.appendChild(newItem);
            setupItemEventListeners(newItem);
        });
    }
    
    calculateSaleTotal();
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush