@extends('layouts.app')

@section('title', 'Create Purchase')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                        <li class="breadcrumb-item active">Create Purchase</li>
                    </ol>
                </div>
                <h4 class="page-title">Create New Purchase</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Purchase Information</h4>
                </div>
                <div class="card-body">
                    <form id="purchaseForm" method="POST" action="{{ route('purchases.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                                    <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                    </select>
                                    @error('supplier_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Enter purchase notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Purchase Items</h5>
                                <div id="purchaseItems">
                                    <div class="purchase-item border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                                    <select class="form-select product-select" name="items[0][product_id]" required>
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" value="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Unit Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control price-input" name="items[0][price]" min="0.01" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Total</label>
                                                    <input type="text" class="form-control total-display" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn btn-danger btn-sm d-block remove-item">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-secondary" id="addItem">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="totalAmount" name="total_amount" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Create Purchase</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;
    
    loadSuppliers();
    loadProducts(0);
    
    document.getElementById('addItem').addEventListener('click', function() {
        itemIndex++;
        addPurchaseItem(itemIndex);
        loadProducts(itemIndex);
    });
    
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        // Let the server-side validation handle errors for standard web form submit
    });
    
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
            calculateItemTotal(e.target.closest('.purchase-item'));
        }
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            removePurchaseItem(e.target);
        }
    });
});

function loadSuppliers() {
    fetch('/api/v1/suppliers', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const supplierSelect = document.getElementById('supplier_id');
        supplierSelect.innerHTML = '<option value="">Select Supplier</option>';
        
        data.data.forEach(supplier => {
            const option = document.createElement('option');
            option.value = supplier.id;
            option.textContent = supplier.name;
            supplierSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error loading suppliers:', error);
    });
}

function loadProducts(itemIndex) {
    fetch('/api/v1/products?all=1', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const productSelect = document.querySelector(`select[name="items[${itemIndex}][product_id]"]`);
        if (productSelect) {
            productSelect.innerHTML = '<option value="">Select Product</option>';
            
            data.data.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} (${product.sku})`;
                option.dataset.price = product.cost_price || product.price;
                productSelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error loading products:', error);
    });
}

function addPurchaseItem(index) {
    const template = `
        <div class="purchase-item border rounded p-3 mb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <select class="form-select product-select" name="items[${index}][product_id]" required>
                            <option value="">Select Product</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control quantity-input" name="items[${index}][quantity]" min="1" value="1" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Unit Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control price-input" name="items[${index}][price]" min="0.01" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <input type="text" class="form-control total-display" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm d-block remove-item">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('purchaseItems').insertAdjacentHTML('beforeend', template);
}

function removePurchaseItem(button) {
    const item = button.closest('.purchase-item');
    if (document.querySelectorAll('.purchase-item').length > 1) {
        item.remove();
        calculateTotalAmount();
    }
}

function calculateItemTotal(itemElement) {
    const quantity = parseFloat(itemElement.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(itemElement.querySelector('.price-input').value) || 0;
    const total = quantity * price;
    
    itemElement.querySelector('.total-display').value = total.toFixed(2);
    calculateTotalAmount();
}

function calculateTotalAmount() {
    let total = 0;
    document.querySelectorAll('.total-display').forEach(display => {
        total += parseFloat(display.value) || 0;
    });
    
    document.getElementById('totalAmount').value = total.toFixed(2);
}
</script>
@endpush
@endsection