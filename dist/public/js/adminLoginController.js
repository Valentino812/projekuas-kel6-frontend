app.controller('AdminLoginController', function($scope, $timeout, $http) {
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

    $scope.adminLoginData = {
        username: '',
        password: '',
    };

    $scope.errorMessage = '';
    $scope.successMessage = '';

    $scope.adminLogin = function() {
        $http.post('/api/admin-login', $scope.adminLoginData)
        .then(function(response) {
            $scope.successMessage = response.data.message;
            $scope.errorMessage = '';
            $scope.adminLoginData = {};
            
            // Redirect user to the provided URL
            if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
            }
        })
        .catch(function(error) {
            if (error.data && error.data.errors) {
                $scope.errorMessage = error.data.errors;
            } else {
                $scope.errorMessage = 'An error occurred. Please try again.';
            }
        });
    }
});
