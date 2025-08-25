// Inventory Management System - Main AngularJS App
angular.module('inventoryApp', ['ngRoute'])

.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider
        // Authentication Routes
        .when('/login', {
            templateUrl: '/assets/templates/auth/login.html',
            controller: 'AuthController',
            controllerAs: 'auth',
            resolve: {
                authenticated: ['AuthService', function(AuthService) {
                    if (AuthService.isAuthenticated()) {
                        window.location.href = '#/dashboard';
                        return false;
                    }
                    return true;
                }]
            }
        })
        
        // Dashboard
        .when('/dashboard', {
            templateUrl: '/assets/templates/dashboard/dashboard.html',
            controller: 'DashboardController',
            controllerAs: 'dashboard',
            requireAuth: true
        })
        
        // Products
        .when('/products', {
            templateUrl: '/assets/templates/products/list.html',
            controller: 'ProductController',
            controllerAs: 'product',
            requireAuth: true
        })
        .when('/products/create', {
            templateUrl: '/assets/templates/products/form.html',
            controller: 'ProductController',
            controllerAs: 'product',
            requireAuth: true,
            requireRole: ['ADMIN', 'MANAGER']
        })
        .when('/products/:id/edit', {
            templateUrl: '/assets/templates/products/form.html',
            controller: 'ProductController',
            controllerAs: 'product',
            requireAuth: true,
            requireRole: ['ADMIN', 'MANAGER']
        })
        .when('/products/:id', {
            templateUrl: '/assets/templates/products/detail.html',
            controller: 'ProductController',
            controllerAs: 'product',
            requireAuth: true
        })
        
        // Categories
        .when('/categories', {
            templateUrl: '/assets/templates/categories/list.html',
            controller: 'CategoryController',
            controllerAs: 'category',
            requireAuth: true
        })
        
        // Suppliers
        .when('/suppliers', {
            templateUrl: '/assets/templates/suppliers/list.html',
            controller: 'SupplierController',
            controllerAs: 'supplier',
            requireAuth: true
        })
        
        // Stock Management
        .when('/stock', {
            templateUrl: '/assets/templates/stock/list.html',
            controller: 'StockController',
            controllerAs: 'stock',
            requireAuth: true
        })
        .when('/stock/report', {
            templateUrl: '/assets/templates/stock/report.html',
            controller: 'StockController',
            controllerAs: 'stock',
            requireAuth: true
        })
        
        // User Management (Admin only)
        .when('/users', {
            templateUrl: '/assets/templates/users/list.html',
            controller: 'UserController',
            controllerAs: 'user',
            requireAuth: true,
            requireRole: ['ADMIN']
        })
        
        // Profile
        .when('/profile', {
            templateUrl: '/assets/templates/auth/profile.html',
            controller: 'AuthController',
            controllerAs: 'auth',
            requireAuth: true
        })
        
        // Default redirect
        .when('/', {
            redirectTo: '/dashboard'
        })
        
        // 404 Page
        .otherwise({
            templateUrl: '/assets/templates/error/404.html'
        });
}])

// HTTP Interceptor for Authentication
.factory('AuthInterceptor', ['$q', '$location', 'AuthService', 'AlertService', 
function($q, $location, AuthService, AlertService) {
    return {
        request: function(config) {
            // Add Authorization header to all API requests
            if (config.url.startsWith('/api/') && AuthService.getToken()) {
                config.headers.Authorization = 'Bearer ' + AuthService.getToken();
            }
            return config;
        },
        
        responseError: function(rejection) {
            // Handle authentication errors
            if (rejection.status === 401) {
                AuthService.logout();
                $location.path('/login');
                AlertService.error('Session expired. Please login again.');
            } else if (rejection.status === 403) {
                AlertService.error('Access denied. Insufficient permissions.');
            } else if (rejection.status === 500) {
                AlertService.error('Server error. Please try again later.');
            }
            
            return $q.reject(rejection);
        }
    };
}])

.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('AuthInterceptor');
}])

// Route Change Handler for Authentication
.run(['$rootScope', '$location', 'AuthService', 'AlertService', 
function($rootScope, $location, AuthService, AlertService) {
    
    // Initialize alerts array
    $rootScope.alerts = [];
    
    // Loading state
    $rootScope.loading = false;
    
    // Remove alert function
    $rootScope.removeAlert = function(index) {
        $rootScope.alerts.splice(index, 1);
    };
    
    // Route change start - show loading
    $rootScope.$on('$routeChangeStart', function(event, next, current) {
        $rootScope.loading = true;
        
        // Check authentication
        if (next.requireAuth && !AuthService.isAuthenticated()) {
            event.preventDefault();
            $location.path('/login');
            return;
        }
        
        // Check role-based access
        if (next.requireRole && AuthService.isAuthenticated()) {
            var currentUser = AuthService.getCurrentUser();
            if (!currentUser || next.requireRole.indexOf(currentUser.role) === -1) {
                event.preventDefault();
                AlertService.error('Access denied. Insufficient permissions.');
                $location.path('/dashboard');
                return;
            }
        }
    });
    
    // Route change success - hide loading
    $rootScope.$on('$routeChangeSuccess', function() {
        $rootScope.loading = false;
    });
    
    // Route change error - hide loading and show error
    $rootScope.$on('$routeChangeError', function() {
        $rootScope.loading = false;
        AlertService.error('Failed to load page. Please try again.');
    });
    
    // Initialize current user if authenticated
    if (AuthService.isAuthenticated()) {
        AuthService.validateToken().then(function(response) {
            $rootScope.currentUser = response.data.user;
        }).catch(function() {
            AuthService.logout();
            $location.path('/login');
        });
    }
}])

// Global Error Handler
.factory('$exceptionHandler', ['$log', 'AlertService', function($log, AlertService) {
    return function(exception, cause) {
        $log.error('Application Error:', exception, cause);
        AlertService.error('An unexpected error occurred. Please refresh the page.');
    };
}])

// Utility Filters
.filter('capitalize', function() {
    return function(input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    };
})

.filter('currency', function() {
    return function(amount, symbol) {
        symbol = symbol || '$';
        if (isNaN(amount)) return symbol + '0.00';
        return symbol + parseFloat(amount).toFixed(2);
    };
})

.filter('stockStatus', function() {
    return function(quantity, minimumStock) {
        if (quantity <= 0) return 'Out of Stock';
        if (quantity <= minimumStock) return 'Low Stock';
        return 'In Stock';
    };
})

.filter('stockStatusClass', function() {
    return function(quantity, minimumStock) {
        if (quantity <= 0) return 'out-of-stock';
        if (quantity <= minimumStock) return 'low-stock';
        return 'in-stock';
    };
})

.filter('roleClass', function() {
    return function(role) {
        return role ? role.toLowerCase() : '';
    };
})

// Global Constants
.constant('API_CONFIG', {
    BASE_URL: '/api',
    TIMEOUT: 30000
})

.constant('APP_CONFIG', {
    APP_NAME: 'Inventory Management System',
    VERSION: '1.0.0',
    PAGINATION_SIZE: 10,
    MAX_FILE_SIZE: 5242880 // 5MB
});