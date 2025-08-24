@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $product->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Product Details</h4>
                        <div class="btn-group">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>SKU:</strong></td>
                                    <td><span class="badge bg-info">{{ $product->sku }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $product->description ?: 'No description available' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($product->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($product->status === 'inactive')
                                            <span class="badge bg-warning">Inactive</span>
                                        @else
                                            <span class="badge bg-danger">Discontinued</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>
                                        @if($product->category)
                                            <a href="{{ route('categories.show', $product->category->id) }}">
                                                {{ $product->category->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td>
                                        @if($product->supplier)
                                            <a href="{{ route('suppliers.show', $product->supplier->id) }}">
                                                {{ $product->supplier->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">No supplier</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Pricing & Stock</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td><span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Cost Price:</strong></td>
                                    <td>
                                        @if($product->cost_price)
                                            ${{ number_format($product->cost_price, 2) }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Quantity:</strong></td>
                                    <td>
                                        @if($product->quantity > 0)
                                            <span class="badge bg-success">{{ $product->quantity }}</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Low Stock Threshold:</strong></td>
                                    <td>{{ $product->low_stock_threshold ?? 10 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Reorder Point:</strong></td>
                                    <td>{{ $product->reorder_point ?? 5 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Max Stock:</strong></td>
                                    <td>{{ $product->max_stock ?: 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($product->brand || $product->model || $product->weight || $product->length || $product->width || $product->height)
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Product Specifications</h5>
                            <table class="table table-borderless">
                                @if($product->brand)
                                <tr>
                                    <td><strong>Brand:</strong></td>
                                    <td>{{ $product->brand }}</td>
                                </tr>
                                @endif
                                @if($product->model)
                                <tr>
                                    <td><strong>Model:</strong></td>
                                    <td>{{ $product->model }}</td>
                                </tr>
                                @endif
                                @if($product->weight)
                                <tr>
                                    <td><strong>Weight:</strong></td>
                                    <td>{{ $product->weight }} kg</td>
                                </tr>
                                @endif
                                @if($product->length || $product->width || $product->height)
                                <tr>
                                    <td><strong>Dimensions:</strong></td>
                                    <td>
                                        @if($product->length && $product->width && $product->height)
                                            {{ $product->length }} × {{ $product->width }} × {{ $product->height }} cm
                                        @else
                                            <span class="text-muted">Incomplete dimensions</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if($product->barcode)
                                <tr>
                                    <td><strong>Barcode:</strong></td>
                                    <td><code>{{ $product->barcode }}</code></td>
                                </tr>
                                @endif
                                @if($product->expiry_date)
                                <tr>
                                    <td><strong>Expiry Date:</strong></td>
                                    <td>{{ $product->expiry_date->format('M d, Y') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Stock Alerts</h5>
                            <div class="alert alert-info">
                                @if($product->quantity <= ($product->low_stock_threshold ?? 10))
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Low Stock Alert:</strong> 
                                    Current quantity ({{ $product->quantity }}) is below the threshold ({{ $product->low_stock_threshold ?? 10 }})
                                @elseif($product->quantity == 0)
                                    <i class="fas fa-times-circle"></i>
                                    <strong>Out of Stock:</strong> 
                                    This product needs immediate restocking
                                @else
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Stock Level OK:</strong> 
                                    Current quantity ({{ $product->quantity }}) is above the threshold
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Recent Activity</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->purchaseItems->take(5) as $item)
                                        <tr>
                                            <td>{{ $item->purchase->date->format('M d, Y') }}</td>
                                            <td><span class="badge bg-primary">Purchase</span></td>
                                            <td>+{{ $item->quantity }}</td>
                                            <td>
                                                <a href="{{ route('purchases.show', $item->purchase->id) }}">
                                                    Purchase #{{ $item->purchase->id }}
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent purchase activity</td>
                                        </tr>
                                        @endforelse
                                        
                                        @forelse($product->saleItems->take(5) as $item)
                                        <tr>
                                            <td>{{ $item->sale->date->format('M d, Y') }}</td>
                                            <td><span class="badge bg-success">Sale</span></td>
                                            <td>-{{ $item->quantity }}</td>
                                            <td>
                                                <a href="{{ route('sales.show', $item->sale->id) }}">
                                                    Sale #{{ $item->sale->id }}
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No recent sale activity</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection