@extends('layouts.app')

@section('title', 'Create Sale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active">Create Sale</li>
                    </ol>
                </div>
                <h4 class="page-title">Create New Sale</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Sale Information</h4>
                </div>
                <div class="card-body">
                    <form id="saleForm" method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Sale Date <span class="text-danger">*</span></label>
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
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Enter sale notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Sale Items</h5>
                                <div id="saleItems">
                                    <div class="sale-item border rounded p-3 mb-3">
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <small class="text-muted stock-info"></small>
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
                                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Create Sale</button>
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
    
    loadProducts(0);
    
    document.getElementById('addItem').addEventListener('click', function() {
        itemIndex++;
        addSaleItem(itemIndex);
        loadProducts(itemIndex);
    });
    
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        // Standard form submit; server-side validates
    });
    
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
            calculateItemTotal(e.target.closest('.sale-item'));
        }
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            removeSaleItem(e.target);
        }
    });
    
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            handleProductSelection(e.target);
        }
    });
});

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
                option.textContent = `${product.name} (${product.sku}) - Stock: ${product.quantity}`;
                option.dataset.price = product.price;
                option.dataset.stock = product.quantity;
                productSelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error loading products:', error);
    });
}

function handleProductSelection(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const itemElement = selectElement.closest('.sale-item');
    
    if (selectedOption && selectedOption.value) {
        const price = selectedOption.dataset.price;
        const stock = parseInt(selectedOption.dataset.stock);
        
        itemElement.querySelector('.price-input').value = price;
        
        const stockInfo = itemElement.querySelector('.stock-info');
        if (stock > 0) {
            stockInfo.textContent = `Available Stock: ${stock}`;
            stockInfo.className = 'text-muted stock-info';
        } else {
            stockInfo.textContent = 'Out of Stock!';
            stockInfo.className = 'text-danger stock-info';
        }
        
        calculateItemTotal(itemElement);
    }
}

function addSaleItem(index) {
    const template = `
        <div class="sale-item border rounded p-3 mb-3">
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
            <div class="row">
                <div class="col-md-12">
                    <small class="text-muted stock-info"></small>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('saleItems').insertAdjacentHTML('beforeend', template);
}

function removeSaleItem(button) {
    const item = button.closest('.sale-item');
    if (document.querySelectorAll('.sale-item').length > 1) {
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