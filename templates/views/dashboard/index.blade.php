@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Dashboard</h1>
            <small class="text-muted">{{ now()->format('F j, Y') }}</small>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $totalProducts }}</h4>
                        <p class="mb-0">Total Products</p>
                    </div>
                    <i class="bi bi-box fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $totalCategories }}</h4>
                        <p class="mb-0">Categories</p>
                    </div>
                    <i class="bi bi-tags fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $totalSuppliers }}</h4>
                        <p class="mb-0">Suppliers</p>
                    </div>
                    <i class="bi bi-truck fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $lowStockCount }}</h4>
                        <p class="mb-0">Low Stock Items</p>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Low Stock Products -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Low Stock Products</h5>
                <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($lowStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong><br>
                                        <small class="text-muted">{{ $product->sku }}</small>
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ $product->quantity }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No low stock products found.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Purchases</h5>
            </div>
            <div class="card-body">
                @if($recentPurchases->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentPurchases as $purchase)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $purchase->supplier->name }}</strong><br>
                                    <small class="text-muted">{{ $purchase->date->format('M j, Y') }}</small>
                                </div>
                                <span class="badge bg-success">${{ number_format($purchase->total_amount, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No recent purchases found.</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Recent Sales</h5>
            </div>
            <div class="card-body">
                @if($recentSales->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentSales as $sale)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $sale->customer_name }}</strong><br>
                                    <small class="text-muted">{{ $sale->date->format('M j, Y') }}</small>
                                </div>
                                <span class="badge bg-primary">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No recent sales found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
