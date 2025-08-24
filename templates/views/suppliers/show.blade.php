@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        <li class="breadcrumb-item active">{{ $supplier->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $supplier->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Supplier Details</h4>
                        <div class="btn-group">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Contact Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Company Name:</strong></td>
                                    <td>{{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Contact Person:</strong></td>
                                    <td>{{ $supplier->contact_person ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>
                                        <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>
                                        @if($supplier->phone)
                                            <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tax ID:</strong></td>
                                    <td>
                                        @if($supplier->tax_id)
                                            <code>{{ $supplier->tax_id }}</code>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Address Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td>{{ $supplier->address ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>City:</strong></td>
                                    <td>{{ $supplier->city ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>State:</strong></td>
                                    <td>{{ $supplier->state ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Postal Code:</strong></td>
                                    <td>{{ $supplier->postal_code ?: 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Country:</strong></td>
                                    <td>{{ $supplier->country ?: 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($supplier->notes)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Notes</h5>
                            <div class="alert alert-info">
                                {{ $supplier->notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Statistics</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $supplier->products->count() }}</h3>
                                            <p class="mb-0">Products</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $supplier->purchases->count() }}</h3>
                                            <p class="mb-0">Purchases</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Recent Activity</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supplier->purchases->take(5) as $purchase)
                                        <tr>
                                            <td>{{ $purchase->date->format('M d, Y') }}</td>
                                            <td><span class="badge bg-primary">Purchase</span></td>
                                            <td>
                                                <a href="{{ route('purchases.show', $purchase->id) }}">
                                                    Purchase #{{ $purchase->id }}
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No recent purchase activity</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($supplier->products->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Supplied Products</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier->products as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-info">{{ $product->sku }}</span></td>
                                            <td>
                                                @if($product->category)
                                                    <a href="{{ route('categories.show', $product->category->id) }}">
                                                        {{ $product->category->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No category</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                @if($product->quantity > 0)
                                                    <span class="badge bg-success">{{ $product->quantity }}</span>
                                                @else
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($product->status === 'inactive')
                                                    <span class="badge bg-warning">Inactive</span>
                                                @else
                                                    <span class="badge bg-danger">Discontinued</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($supplier->purchases->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Purchase History</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Purchase #</th>
                                            <th>Items</th>
                                            <th>Total Amount</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier->purchases->take(10) as $purchase)
                                        <tr>
                                            <td>{{ $purchase->date->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('purchases.show', $purchase->id) }}">
                                                    #{{ $purchase->id }}
                                                </a>
                                            </td>
                                            <td>{{ $purchase->purchaseItems->count() }} items</td>
                                            <td>${{ number_format($purchase->total_amount, 2) }}</td>
                                            <td>
                                                @if($purchase->notes)
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $purchase->notes }}">
                                                        {{ $purchase->notes }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">No notes</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection