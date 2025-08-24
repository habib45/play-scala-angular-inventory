angular.module('inventoryApp')
.factory('AlertService', ['$rootScope', '$timeout', function($rootScope, $timeout) {
    var service = {};
    var alerts = [];

    // Initialize alerts in rootScope if not exists
    if (!$rootScope.alerts) {
        $rootScope.alerts = alerts;
    } else {
        alerts = $rootScope.alerts;
    }

    service.add = function(type, message, timeout) {
        var alert = {
            type: type,
            message: message,
            id: Date.now() + Math.random()
        };

        alerts.push(alert);

        // Auto-remove alert after timeout (default 5 seconds)
        if (timeout !== false) {
            $timeout(function() {
                service.remove(alert.id);
            }, timeout || 5000);
        }

        return alert.id;
    };

    service.success = function(message, timeout) {
        return service.add('success', message, timeout);
    };

    service.error = function(message, timeout) {
        return service.add('danger', message, timeout);
    };

    service.warning = function(message, timeout) {
        return service.add('warning', message, timeout);
    };

    service.info = function(message, timeout) {
        return service.add('info', message, timeout);
    };

    service.remove = function(alertId) {
        for (var i = 0; i < alerts.length; i++) {
            if (alerts[i].id === alertId) {
                alerts.splice(i, 1);
                break;
            }
        }
    };

    service.clear = function() {
        alerts.length = 0;
    };

    service.getAlerts = function() {
        return alerts;
    };

    // Helper function to handle API error responses
    service.handleError = function(error, defaultMessage) {
        var message = defaultMessage || 'An error occurred';
        
        if (error && error.data) {
            if (error.data.error) {
                message = error.data.error;
            } else if (error.data.message) {
                message = error.data.message;
            }
        } else if (error && error.message) {
            message = error.message;
        }

        service.error(message);
    };

    // Helper function to handle API success responses
    service.handleSuccess = function(response, defaultMessage) {
        var message = defaultMessage || 'Operation completed successfully';
        
        if (response && response.data) {
            if (response.data.message) {
                message = response.data.message;
            }
        }

        service.success(message);
    };

    return service;
}]);