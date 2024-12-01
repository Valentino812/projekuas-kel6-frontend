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

    $scope.accountData = {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
    };

    $scope.errorMessage = '';
    $scope.successMessage = '';

    $scope.accountUpdate = function() {
        $http.put('/api/account-update/' + $scope.userId, $scope.accountData)
        .then(function(response) {
            $scope.successMessage = response.data.message;
            $scope.errorMessage = '';
            $scope.accountData = {};            
        })
        .catch(function(error) {
            if (error.data && error.data.errors) {
                $scope.errorMessage = error.data.errors;
            } else {
                $scope.errorMessage = 'An error occurred. Please try again.';
            }
            $scope.successMessage = '';
        });
    };

    $scope.updateAccount = function() {
        console.log($scope.accountData);
    };

     // LOGIN
    // Check if the 'id' is part of the route
    $scope.userId = $routeParams.id;

    if($scope.userId){
        $scope.getAccountInfo = function(userId) {
            // console.log('Fetching Account Info for User ID:', userId);
        
            $http.get('/api/account-info/' + userId)
                .then(function(response) {
                    // console.log('Response from API:', response); 
                    $scope.accountInfo = response.data.account;
                    console.log('Account Info:', $scope.accountInfo); 
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
})