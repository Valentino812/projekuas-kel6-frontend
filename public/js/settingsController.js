app.controller('SettingsController', function($scope, $timeout, $http, $routeParams) {
    // Using jQuery to change an element's style after the page is loaded
    $scope.$on('$viewContentLoaded', function() {
        // This ensures the DOM is fully loaded before running jQuery
        $('#homeMessage').css('color', 'red');
    });

    // Using jQuery with AngularJS $timeout to trigger after Angular rendering
    $timeout(function() {
        $('#homeMessage').fadeIn();
    }, 500); // Delay to let Angular render first

    // Entrance Transition Start (using jQuery for simpler syntax)
    // Trigger the active class to do the transition for fade-in
    $('.fade-in').each(function(index) {
        $(this).delay(150 * index).queue(function(next) { // 150ms delay between transitions of each element 
            $(this).addClass('active');
            next();
        });
    });
    // Entrance Transition End

    const burgerMenu = document.getElementById('burger-menu');
    const navbarMenu = document.querySelector('.navbar-menu');
    const closeButton = document.getElementById('close-button');

    burgerMenu.addEventListener('click', () => {
        navbarMenu.classList.toggle('active');
        burgerMenu.classList.toggle('active');
    });

    closeButton.addEventListener('click', () => {
        navbarMenu.classList.remove('active');
        burgerMenu.classList.remove('active');
    });



    $scope.updateAccount = function() {
        console.log($scope.accountData);
    };

    // Check if the 'id' is part of the route
    $scope.userId = $routeParams.id;

    if($scope.userId){
        $scope.errorMessage = '';
        $scope.successMessage = '';

        $scope.getAccountInfo = function(userId) {
        
            $http.get('/api/account-info/' + userId)
                .then(function(response) {
                    $scope.accountInfo = response.data.account;
                    console.log('Account Info:', $scope.accountInfo); 

                    // Pre-fill accountData with the fetched account information
                    $scope.accountData = {
                        first_name: $scope.accountInfo.first_name || '', 
                        last_name: $scope.accountInfo.last_name || '',
                        email: $scope.accountInfo.email || '',
                        password: '', // Keep password blank for security reasons
                        new_password: ''
                    };

                    $scope.errorMessage = '';
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    if (error.data && error.data.message) {
                        $scope.errorMessage = error.data.message;
                    } else {
                        $scope.errorMessage = 'An error occurred. Please try again.';
                    }
                });
        };
        
        // Call getAccountInfo 
        $scope.getAccountInfo($scope.userId);
    }

    $scope.errorMessageInfo = '';
    $scope.successMessageInfo = '';

    // Update Account Info (First Name and Last Name)
    $scope.accountInfoUpdate = function () {
        // Send only the first_name and last_name properties from accountData
        $http.patch('/api/accountInfo-update/' + $scope.userId, {
            first_name: $scope.accountData.first_name,
            last_name: $scope.accountData.last_name
        })
            .then(function (response) {
                $scope.successMessageInfo = response.data.message || 'Account info updated successfully.';
                $scope.errorMessageInfo = '';
            })
            .catch(function (error) {
                if (error.data && error.data.errors) {
                    $scope.errorMessageInfo = error.data.errors;
                } else {
                    $scope.errorMessageInfo = 'An error occurred. Please try again.';
                }
                $scope.successMessageInfo = '';
            });
    };

    $scope.errorMessageLogin = '';
    $scope.successMessageLogin = '';

    // Update Login Info (Email and Password)
    $scope.accountLoginUpdate = function () {
        $http.patch('/api/accountLogin-update/' + $scope.userId, {
            email: $scope.accountData.email,
            password: $scope.accountData.password,
            new_password: $scope.accountData.new_password,
        })
            .then(function (response) {
                $scope.successMessageLogin = response.data.message || 'Login info updated successfully.';
                $scope.errorMessageLogin = '';
                $scope.accountData.password = '',
                $scope.accountData.new_password=''
            })
            .catch(function (error) {
                if (error.data && error.data.errors) {
                    $scope.errorMessageLogin = error.data.errors;
                } else {
                    $scope.errorMessageLogin = 'An error occurred. Please try again.';
                }
                $scope.successMessageLogin = '';
            });
    };

})