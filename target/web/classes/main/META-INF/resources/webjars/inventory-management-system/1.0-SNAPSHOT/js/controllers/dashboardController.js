angular.module('inventoryApp')
.controller('DashboardController', ['$scope', 'ApiService', 'AlertService', 'AuthService',
function($scope, ApiService, AlertService, AuthService) {
    var vm = this;
    
    // Dashboard data
    vm.stats = {
        totalProducts: 0,
        totalCategories: 0,
        totalSuppliers: 0,
        totalStockValue: 0,
        lowStockCount: 0
    };
    
    vm.lowStockAlerts = [];
    vm.recentProducts = [];
    vm.loading = true;
    vm.currentUser = AuthService.getCurrentUser();

    // Initialize dashboard
    vm.init = function() {
        vm.loading = true;
        
        // Load all dashboard data
        var promises = [
            ApiService.products.count(),
            ApiService.categories.count(),
            ApiService.suppliers.count(),
            ApiService.stock.getTotalValue(),
            ApiService.stock.getLowStock(),
            ApiService.products.getAll({ limit: 5, withDetails: true })
        ];

        Promise.all(promises.map(function(p) {
            return p.then(function(response) {
                return response.data;
            }).catch(function(error) {
                console.error('Dashboard API error:', error);
                return null;
            });
        })).then(function(results) {
            vm.stats.totalProducts = results[0] ? results[0].count : 0;
            vm.stats.totalCategories = results[1] ? results[1].count : 0;
            vm.stats.totalSuppliers = results[2] ? results[2].count : 0;
            vm.stats.totalStockValue = results[3] ? results[3].totalValue : 0;
            vm.lowStockAlerts = results[4] || [];
            vm.stats.lowStockCount = vm.lowStockAlerts.length;
            vm.recentProducts = results[5] || [];
            
            $scope.$apply();
            vm.initCharts();
        }).catch(function(error) {
            console.error('Dashboard initialization error:', error);
            AlertService.error('Failed to load dashboard data');
        }).finally(function() {
            vm.loading = false;
            $scope.$apply();
        });
    };

    // Initialize charts
    vm.initCharts = function() {
        // Stock Status Chart
        var stockStatusCtx = document.getElementById('stockStatusChart');
        if (stockStatusCtx) {
            var inStockCount = vm.stats.totalProducts - vm.stats.lowStockCount;
            new Chart(stockStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['In Stock', 'Low Stock'],
                    datasets: [{
                        data: [inStockCount, vm.stats.lowStockCount],
                        backgroundColor: ['#28a745', '#ffc107'],
                        borderWidth: 0
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
        }

        // Category Distribution Chart (placeholder data)
        var categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx && vm.recentProducts.length > 0) {
            var categoryData = {};
            vm.recentProducts.forEach(function(product) {
                categoryData[product.categoryName] = (categoryData[product.categoryName] || 0) + 1;
            });

            new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(categoryData),
                    datasets: [{
                        label: 'Products by Category',
                        data: Object.values(categoryData),
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
                    }
                }
            });
        }
    };

    // Utility functions
    vm.getStockStatusClass = function(quantity, minimumStock) {
        if (quantity <= 0) return 'danger';
        if (quantity <= minimumStock) return 'warning';
        return 'success';
    };

    vm.getStockStatusText = function(quantity, minimumStock) {
        if (quantity <= 0) return 'Out of Stock';
        if (quantity <= minimumStock) return 'Low Stock';
        return 'In Stock';
    };

    vm.formatCurrency = function(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2);
    };

    // Refresh dashboard data
    vm.refresh = function() {
        vm.init();
    };

    // Initialize on load
    vm.init();
}]);