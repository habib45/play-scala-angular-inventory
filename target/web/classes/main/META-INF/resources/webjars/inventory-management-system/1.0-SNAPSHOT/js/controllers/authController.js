angular.module('inventoryApp')
.controller('AuthController', ['$scope', '$location', 'AuthService', 'AlertService',
function($scope, $location, AuthService, AlertService) {
    var vm = this;
    
    // Login form
    vm.loginForm = {
        username: '',
        password: ''
    };
    
    // Change password form
    vm.passwordForm = {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
    };
    
    // Loading states
    vm.loginLoading = false;
    vm.passwordLoading = false;
    
    // Current user for profile
    vm.currentUser = AuthService.getCurrentUser();

    // Login function
    vm.login = function() {
        if (vm.loginForm.username && vm.loginForm.password) {
            vm.loginLoading = true;
            
            AuthService.login({
                username: vm.loginForm.username,
                password: vm.loginForm.password
            }).then(function(response) {
                AlertService.success('Welcome back, ' + response.user.username + '!');
                $location.path('/dashboard');
            }).catch(function(error) {
                AlertService.handleError(error, 'Login failed. Please check your credentials.');
            }).finally(function() {
                vm.loginLoading = false;
            });
        } else {
            AlertService.error('Please enter both username and password.');
        }
    };

    // Change password function
    vm.changePassword = function() {
        if (!vm.passwordForm.currentPassword || !vm.passwordForm.newPassword) {
            AlertService.error('Please fill in all password fields.');
            return;
        }

        if (vm.passwordForm.newPassword !== vm.passwordForm.confirmPassword) {
            AlertService.error('New password and confirmation do not match.');
            return;
        }

        if (vm.passwordForm.newPassword.length < 8) {
            AlertService.error('New password must be at least 8 characters long.');
            return;
        }

        vm.passwordLoading = true;

        AuthService.changePassword({
            currentPassword: vm.passwordForm.currentPassword,
            newPassword: vm.passwordForm.newPassword
        }).then(function(response) {
            AlertService.handleSuccess(response, 'Password changed successfully');
            vm.passwordForm = {
                currentPassword: '',
                newPassword: '',
                confirmPassword: ''
            };
        }).catch(function(error) {
            AlertService.handleError(error, 'Failed to change password');
        }).finally(function() {
            vm.passwordLoading = false;
        });
    };

    // Form validation helpers
    vm.isLoginValid = function() {
        return vm.loginForm.username && vm.loginForm.password;
    };

    vm.isPasswordValid = function() {
        return vm.passwordForm.currentPassword && 
               vm.passwordForm.newPassword && 
               vm.passwordForm.confirmPassword &&
               vm.passwordForm.newPassword === vm.passwordForm.confirmPassword &&
               vm.passwordForm.newPassword.length >= 8;
    };

    // Password strength indicator
    vm.getPasswordStrength = function(password) {
        if (!password) return { strength: 0, text: '' };
        
        var strength = 0;
        var text = 'Weak';
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        if (strength >= 4) text = 'Strong';
        else if (strength >= 3) text = 'Medium';
        
        return { strength: strength, text: text };
    };

    // Initialize - redirect if already logged in
    if (AuthService.isAuthenticated() && $location.path() === '/login') {
        $location.path('/dashboard');
    }
}]);