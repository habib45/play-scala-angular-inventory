@extends('layouts.app')

@section('title', 'Purchases')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Purchases
                    </h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPurchaseModal">
                        <i class="fas fa-plus me-2"></i>New Purchase
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search purchases...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="supplierFilter">
                                <option value="">All Suppliers</option>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="received">Received</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Purchases Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="purchasesTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Items</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="purchasesTableBody">
                                <!-- Purchases will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> of <span id="totalRecords">0</span> purchases
                        </div>
                        <nav aria-label="Purchases pagination">
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

<!-- Create Purchase Modal -->
<div class="modal fade" id="createPurchaseModal" tabindex="-1" aria-labelledby="createPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPurchaseModalLabel">
                    <i class="fas fa-plus me-2"></i>Create New Purchase
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createPurchaseForm">
                <div class="modal-body">
                    <!-- Purchase Header -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchaseSupplier" class="form-label">Supplier *</label>
                                <select class="form-select" id="purchaseSupplier" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="supplierError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchaseDate" class="form-label">Purchase Date *</label>
                                <input type="date" class="form-control" id="purchaseDate" name="date" required value="{{ date('Y-m-d') }}">
                                <div class="invalid-feedback" id="dateError"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Items -->
                    <div class="mb-3">
                        <label class="form-label">Purchase Items *</label>
                        <div id="purchaseItems">
                            <div class="purchase-item border rounded p-3 mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label class="form-label">Product *</label>
                                            <select class="form-select product-select" name="items[0][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach($products ?? [] as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                        {{ $product->name }} ({{ $product->sku }})
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

                    <!-- Purchase Summary -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchaseNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="purchaseNotes" name="notes" rows="3" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Purchase Summary</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Items:</strong>
                                        </div>
                                        <div class="col-6" id="totalItems">0</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Amount:</strong>
                                        </div>
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
                        <i class="fas fa-save me-2"></i>Create Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Purchase Modal -->
<div class="modal fade" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPurchaseModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Purchase
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPurchaseForm">
                <input type="hidden" id="editPurchaseId" name="id">
                <div class="modal-body">
                    <!-- Purchase Header -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPurchaseSupplier" class="form-label">Supplier *</label>
                                <select class="form-select" id="editPurchaseSupplier" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="editSupplierError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPurchaseDate" class="form-label">Purchase Date *</label>
                                <input type="date" class="form-control" id="editPurchaseDate" name="date" required>
                                <div class="invalid-feedback" id="editDateError"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Items -->
                    <div class="mb-3">
                        <label class="form-label">Purchase Items *</label>
                        <div id="editPurchaseItems">
                            <!-- Items will be loaded here -->
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="editAddItemBtn">
                            <i class="fas fa-plus me-2"></i>Add Item
                        </button>
                    </div>

                    <!-- Purchase Summary -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPurchaseNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="editPurchaseNotes" name="notes" rows="3" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Purchase Summary</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Items:</strong>
                                        </div>
                                        <div class="col-6" id="editTotalItems">0</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Amount:</strong>
                                        </div>
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
                        <i class="fas fa-save me-2"></i>Update Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePurchaseModal" tabindex="-1" aria-labelledby="deletePurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePurchaseModalLabel">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the purchase "<strong id="deletePurchaseId"></strong>"?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. Deleting a purchase will reverse stock updates.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Delete Purchase
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Purchase Details Modal -->
<div class="modal fade" id="viewPurchaseModal" tabindex="-1" aria-labelledby="viewPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPurchaseModalLabel">
                    <i class="fas fa-eye me-2"></i>Purchase Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Purchase Information</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID:</strong></td>
                                <td id="viewPurchaseId"></td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td id="viewPurchaseDate"></td>
                            </tr>
                            <tr>
                                <td><strong>Supplier:</strong></td>
                                <td id="viewPurchaseSupplier"></td>
                            </tr>
                            <tr>
                                <td><strong>Total Amount:</strong></td>
                                <td id="viewPurchaseTotal"></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td id="viewPurchaseStatus"></td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td id="viewPurchaseCreated"></td>
                            </tr>
                            <tr>
                                <td><strong>Updated:</strong></td>
                                <td id="viewPurchaseUpdated"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Purchase Items</h6>
                        <div id="viewPurchaseItems">
                            <!-- Items will be loaded here -->
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
    let purchases = [];
    let itemCounter = 1;

    // Initialize the page
    loadPurchases();

    // Event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(handleSearch, 300));
    document.getElementById('supplierFilter').addEventListener('change', handleFilter);
    document.getElementById('statusFilter').addEventListener('change', handleFilter);
    document.getElementById('refreshBtn').addEventListener('click', loadPurchases);
    document.getElementById('createPurchaseForm').addEventListener('submit', handleCreatePurchase);
    document.getElementById('editPurchaseForm').addEventListener('submit', handleEditPurchase);
    document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeletePurchase);
    document.getElementById('addItemBtn').addEventListener('click', addPurchaseItem);
    document.getElementById('editAddItemBtn').addEventListener('click', addEditPurchaseItem);

    // Load purchases from API
    async function loadPurchases() {
        try {
            showLoading();
            const response = await fetch('/api/v1/purchases');
            if (response.ok) {
                const data = await response.json();
                purchases = data.data;
                displayPurchases();
                updatePagination();
            } else {
                showError('Failed to load purchases');
            }
        } catch (error) {
            showError('Error loading purchases: ' + error.message);
        } finally {
            hideLoading();
        }
    }

    // Display purchases in table
    function displayPurchases() {
        const tbody = document.getElementById('purchasesTableBody');
        tbody.innerHTML = '';

        if (purchases.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                        <p>No purchases found</p>
                    </td>
                </tr>
            `;
            return;
        }

        purchases.forEach(purchase => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${purchase.id}</td>
                <td>${formatDate(purchase.date)}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(purchase.supplier?.name || 'N/A')}</span>
                </td>
                <td>
                    <span class="badge bg-info">${purchase.items?.length || 0} items</span>
                </td>
                <td>
                    <span class="fw-bold text-success">$${parseFloat(purchase.total_amount || 0).toFixed(2)}</span>
                </td>
                <td>
                    <span class="badge bg-success">Received</span>
                </td>
                <td>${formatDate(purchase.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewPurchase(${purchase.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editPurchase(${purchase.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deletePurchase(${purchase.id})" title="Delete">
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
        const supplierFilter = document.getElementById('supplierFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        const filteredPurchases = purchases.filter(purchase => {
            const matchesSearch = purchase.id.toString().includes(searchTerm) ||
                                (purchase.supplier?.name && purchase.supplier.name.toLowerCase().includes(searchTerm));
            
            const matchesSupplier = !supplierFilter || purchase.supplier_id == supplierFilter;
            const matchesStatus = !statusFilter || purchase.status === statusFilter;
            
            return matchesSearch && matchesSupplier && matchesStatus;
        });
        
        displayFilteredPurchases(filteredPurchases);
    }

    function handleFilter() {
        handleSearch();
    }

    // Display filtered purchases
    function displayFilteredPurchases(filteredPurchases) {
        const tbody = document.getElementById('purchasesTableBody');
        tbody.innerHTML = '';

        if (filteredPurchases.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <p>No purchases match your criteria</p>
                    </td>
                </tr>
            `;
            return;
        }

        filteredPurchases.forEach(purchase => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${purchase.id}</td>
                <td>${formatDate(purchase.date)}</td>
                <td>
                    <span class="fw-bold">${escapeHtml(purchase.supplier?.name || 'N/A')}</span>
                </td>
                <td>
                    <span class="badge bg-info">${purchase.items?.length || 0} items</span>
                </td>
                <td>
                    <span class="fw-bold text-success">$${parseFloat(purchase.total_amount || 0).toFixed(2)}</span>
                </td>
                <td>
                    <span class="badge bg-success">Received</span>
                </td>
                <td>${formatDate(purchase.created_at)}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="viewPurchase(${purchase.id})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="editPurchase(${purchase.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="deletePurchase(${purchase.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Handle create purchase
    async function handleCreatePurchase(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const purchaseData = {
            supplier_id: formData.get('supplier_id'),
            date: formData.get('date'),
            notes: formData.get('notes'),
            items: []
        };

        // Collect items data
        const itemElements = document.querySelectorAll('#purchaseItems .purchase-item');
        itemElements.forEach((item, index) => {
            const productId = item.querySelector('.product-select').value;
            const quantity = item.querySelector('.quantity-input').value;
            const price = item.querySelector('.price-input').value;
            
            if (productId && quantity && price) {
                purchaseData.items.push({
                    product_id: productId,
                    quantity: parseInt(quantity),
                    price: parseFloat(price)
                });
            }
        });

        if (purchaseData.items.length === 0) {
            showError('Please add at least one item to the purchase');
            return;
        }

        try {
            const response = await fetch('/api/v1/purchases', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(purchaseData)
            });

            if (response.ok) {
                showSuccess('Purchase created successfully');
                bootstrap.Modal.getInstance(document.getElementById('createPurchaseModal')).hide();
                e.target.reset();
                resetPurchaseForm();
                loadPurchases();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors);
            }
        } catch (error) {
            showError('Error creating purchase: ' + error.message);
        }
    }

    // Handle edit purchase
    async function handleEditPurchase(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const purchaseId = formData.get('id');
        const purchaseData = {
            supplier_id: formData.get('supplier_id'),
            date: formData.get('date'),
            notes: formData.get('notes'),
            items: []
        };

        // Collect items data
        const itemElements = document.querySelectorAll('#editPurchaseItems .purchase-item');
        itemElements.forEach((item, index) => {
            const productId = item.querySelector('.product-select').value;
            const quantity = item.querySelector('.quantity-input').value;
            const price = item.querySelector('.price-input').value;
            
            if (productId && quantity && price) {
                purchaseData.items.push({
                    product_id: productId,
                    quantity: parseInt(quantity),
                    price: parseFloat(price)
                });
            }
        });

        if (purchaseData.items.length === 0) {
            showError('Please add at least one item to the purchase');
            return;
        }

        try {
            const response = await fetch(`/api/v1/purchases/${purchaseId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(purchaseData)
            });

            if (response.ok) {
                showSuccess('Purchase updated successfully');
                bootstrap.Modal.getInstance(document.getElementById('editPurchaseModal')).hide();
                loadPurchases();
            } else {
                const errorData = await response.json();
                showValidationErrors(errorData.errors, 'edit');
            }
        } catch (error) {
            showError('Error updating purchase: ' + error.message);
        }
    }

    // Handle delete purchase
    async function handleDeletePurchase() {
        const purchaseId = document.getElementById('confirmDeleteBtn').getAttribute('data-purchase-id');
        
        try {
            const response = await fetch(`/api/v1/purchases/${purchaseId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                showSuccess('Purchase deleted successfully');
                bootstrap.Modal.getInstance(document.getElementById('deletePurchaseModal')).hide();
                loadPurchases();
            } else {
                const errorData = await response.json();
                showError(errorData.message || 'Failed to delete purchase');
            }
        } catch (error) {
            showError('Error deleting purchase: ' + error.message);
        }
    }

    // Add purchase item
    function addPurchaseItem() {
        const itemsContainer = document.getElementById('purchaseItems');
        const newItem = document.createElement('div');
        newItem.className = 'purchase-item border rounded p-3 mb-2';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product *</label>
                        <select class="form-select product-select" name="items[${itemCounter}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} ({{ $product->sku }})
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
        
        // Add event listeners to new item
        setupItemEventListeners(newItem);
    }

    // Add edit purchase item
    function addEditPurchaseItem() {
        const itemsContainer = document.getElementById('editPurchaseItems');
        const newItem = document.createElement('div');
        newItem.className = 'purchase-item border rounded p-3 mb-2';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product *</label>
                        <select class="form-select product-select" name="items[${itemCounter}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} ({{ $product->sku }})
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
        
        // Add event listeners to new item
        setupItemEventListeners(newItem);
    }

    // Setup item event listeners
    function setupItemEventListeners(item) {
        const productSelect = item.querySelector('.product-select');
        const quantityInput = item.querySelector('.quantity-input');
        const priceInput = item.querySelector('.price-input');
        const removeBtn = item.querySelector('.remove-item');

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

        // Remove item
        removeBtn.addEventListener('click', function() {
            item.remove();
            calculatePurchaseTotal();
        });
    }

    // Calculate item total
    function calculateItemTotal(item) {
        const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(item.querySelector('.price-input').value) || 0;
        const total = quantity * price;
        
        item.querySelector('.item-total').value = total.toFixed(2);
        calculatePurchaseTotal();
    }

    // Calculate purchase total
    function calculatePurchaseTotal() {
        const items = document.querySelectorAll('.purchase-item');
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

    // Reset purchase form
    function resetPurchaseForm() {
        const itemsContainer = document.getElementById('purchaseItems');
        itemsContainer.innerHTML = '';
        itemCounter = 1;
        addPurchaseItem(); // Add one default item
        calculatePurchaseTotal();
    }

    // Setup initial event listeners
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.purchase-item').remove();
            calculatePurchaseTotal();
        }
    });

    // Setup initial item
    setupItemEventListeners(document.querySelector('.purchase-item'));

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
        const total = purchases.length;
        document.getElementById('totalRecords').textContent = total;
        document.getElementById('showingStart').textContent = total > 0 ? 1 : 0;
        document.getElementById('showingEnd').textContent = total;
    }
});

// Global functions for modal actions
function viewPurchase(purchaseId) {
    const purchase = purchases.find(p => p.id === purchaseId);
    if (purchase) {
        document.getElementById('viewPurchaseId').textContent = purchase.id;
        document.getElementById('viewPurchaseDate').textContent = formatDate(purchase.date);
        document.getElementById('viewPurchaseSupplier').textContent = purchase.supplier?.name || 'N/A';
        document.getElementById('viewPurchaseTotal').textContent = `$${parseFloat(purchase.total_amount || 0).toFixed(2)}`;
        document.getElementById('viewPurchaseStatus').innerHTML = '<span class="badge bg-success">Received</span>';
        document.getElementById('viewPurchaseCreated').textContent = formatDate(purchase.created_at);
        document.getElementById('viewPurchaseUpdated').textContent = formatDate(purchase.updated_at);
        
        // Load purchase items
        loadPurchaseItems(purchase);
        
        new bootstrap.Modal(document.getElementById('viewPurchaseModal')).show();
    }
}

function editPurchase(purchaseId) {
    const purchase = purchases.find(p => p.id === purchaseId);
    if (purchase) {
        document.getElementById('editPurchaseId').value = purchase.id;
        document.getElementById('editPurchaseSupplier').value = purchase.supplier_id;
        document.getElementById('editPurchaseDate').value = purchase.date;
        document.getElementById('editPurchaseNotes').value = purchase.notes || '';
        
        // Load purchase items for editing
        loadEditPurchaseItems(purchase);
        
        new bootstrap.Modal(document.getElementById('editPurchaseModal')).show();
    }
}

function deletePurchase(purchaseId) {
    document.getElementById('deletePurchaseId').textContent = purchaseId;
    document.getElementById('confirmDeleteBtn').setAttribute('data-purchase-id', purchaseId);
    
    new bootstrap.Modal(document.getElementById('deletePurchaseModal')).show();
}

async function loadPurchaseItems(purchase) {
    const itemsContainer = document.getElementById('viewPurchaseItems');
    
    if (purchase.items && purchase.items.length > 0) {
        let itemsHtml = '<div class="table-responsive"><table class="table table-sm">';
        itemsHtml += '<thead><tr><th>Product</th><th>SKU</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead><tbody>';
        
        purchase.items.forEach(item => {
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

async function loadEditPurchaseItems(purchase) {
    const itemsContainer = document.getElementById('editPurchaseItems');
    itemsContainer.innerHTML = '';
    
    if (purchase.items && purchase.items.length > 0) {
        purchase.items.forEach((item, index) => {
            const newItem = document.createElement('div');
            newItem.className = 'purchase-item border rounded p-3 mb-2';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label">Product *</label>
                            <select class="form-select product-select" name="items[${index}][product_id]" required>
                                <option value="">Select Product</option>
                                @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" ${item.product_id == {{ $product->id }} ? 'selected' : ''}>
                                        {{ $product->name }} ({{ $product->sku }})
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
    
    calculatePurchaseTotal();
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush