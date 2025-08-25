angular.module('inventoryApp')
.factory('ApiService', ['$http', '$q', 'API_CONFIG', function($http, $q, API_CONFIG) {
    var service = {};

    // Generic HTTP request wrapper
    var request = function(method, url, data, config) {
        config = config || {};
        config.timeout = config.timeout || API_CONFIG.TIMEOUT;
        
        var requestConfig = {
            method: method,
            url: API_CONFIG.BASE_URL + url,
            timeout: config.timeout
        };

        if (data) {
            if (method === 'GET') {
                requestConfig.params = data;
            } else {
                requestConfig.data = data;
            }
        }

        if (config.headers) {
            requestConfig.headers = config.headers;
        }

        return $http(requestConfig);
    };

    // Generic CRUD operations
    service.get = function(url, params) {
        return request('GET', url, params);
    };

    service.post = function(url, data) {
        return request('POST', url, data);
    };

    service.put = function(url, data) {
        return request('PUT', url, data);
    };

    service.delete = function(url) {
        return request('DELETE', url);
    };

    // Product API
    service.products = {
        getAll: function(params) {
            return service.get('/products', params);
        },
        getById: function(id, withDetails) {
            var params = withDetails ? { withDetails: true } : {};
            return service.get('/products/' + id, params);
        },
        create: function(product) {
            return service.post('/products', product);
        },
        update: function(id, product) {
            return service.put('/products/' + id, product);
        },
        delete: function(id) {
            return service.delete('/products/' + id);
        },
        search: function(query, params) {
            var searchParams = angular.extend({ q: query }, params);
            return service.get('/products/search', searchParams);
        },
        getByCategory: function(categoryId, params) {
            return service.get('/products/category/' + categoryId, params);
        },
        getBySupplier: function(supplierId, params) {
            return service.get('/products/supplier/' + supplierId, params);
        },
        filterByPriceRange: function(minPrice, maxPrice, params) {
            var filterParams = angular.extend({ minPrice: minPrice, maxPrice: maxPrice }, params);
            return service.get('/products/price-range', filterParams);
        },
        count: function() {
            return service.get('/products/count');
        }
    };

    // Category API
    service.categories = {
        getAll: function(params) {
            return service.get('/categories', params);
        },
        getById: function(id) {
            return service.get('/categories/' + id);
        },
        create: function(category) {
            return service.post('/categories', category);
        },
        update: function(id, category) {
            return service.put('/categories/' + id, category);
        },
        delete: function(id) {
            return service.delete('/categories/' + id);
        },
        search: function(query, params) {
            var searchParams = angular.extend({ q: query }, params);
            return service.get('/categories/search', searchParams);
        },
        count: function() {
            return service.get('/categories/count');
        }
    };

    // Supplier API
    service.suppliers = {
        getAll: function(params) {
            return service.get('/suppliers', params);
        },
        getById: function(id) {
            return service.get('/suppliers/' + id);
        },
        create: function(supplier) {
            return service.post('/suppliers', supplier);
        },
        update: function(id, supplier) {
            return service.put('/suppliers/' + id, supplier);
        },
        delete: function(id) {
            return service.delete('/suppliers/' + id);
        },
        search: function(query, params) {
            var searchParams = angular.extend({ q: query }, params);
            return service.get('/suppliers/search', searchParams);
        },
        count: function() {
            return service.get('/suppliers/count');
        }
    };

    // Stock API
    service.stock = {
        getAll: function(params) {
            return service.get('/stock', params);
        },
        getById: function(id) {
            return service.get('/stock/' + id);
        },
        getByProductId: function(productId) {
            return service.get('/stock/product/' + productId);
        },
        update: function(productId, stockData) {
            return service.put('/stock/product/' + productId, stockData);
        },
        adjust: function(productId, adjustment, reason) {
            return service.post('/stock/adjust/' + productId, {
                adjustment: adjustment,
                reason: reason || ''
            });
        },
        transfer: function(fromProductId, toProductId, quantity) {
            return service.post('/stock/transfer', {
                fromProductId: fromProductId,
                toProductId: toProductId,
                quantity: quantity
            });
        },
        getLowStock: function() {
            return service.get('/stock/low-stock');
        },
        getTotalValue: function() {
            return service.get('/stock/total-value');
        },
        getReport: function() {
            return service.get('/stock/report');
        },
        count: function() {
            return service.get('/stock/count');
        }
    };

    // User API
    service.users = {
        getAll: function(params) {
            return service.get('/users', params);
        },
        getById: function(id) {
            return service.get('/users/' + id);
        },
        getCurrent: function() {
            return service.get('/users/current');
        },
        create: function(user) {
            return service.post('/users', user);
        },
        update: function(id, user) {
            return service.put('/users/' + id, user);
        },
        delete: function(id) {
            return service.delete('/users/' + id);
        },
        search: function(query, params) {
            var searchParams = angular.extend({ q: query }, params);
            return service.get('/users/search', searchParams);
        },
        getByRole: function(role) {
            return service.get('/users/role/' + role);
        },
        count: function() {
            return service.get('/users/count');
        }
    };

    return service;
}]);