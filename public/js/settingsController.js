app.controller('SettingsController', function($scope, $timeout, $http) {
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
    const cartButton = document.getElementById('cart-button');
    const cartButtonMobile = document.getElementById('cart-button-mobile');
    const accountButton = document.getElementById('account-button');
    const accountButtonMobile = document.getElementById('account-button-mobile');
    const forgotButton = document.getElementById('forgot-button');
    const sidebarCart = document.querySelector('.sidebar-cart');
    const sidebarAccount = document.querySelector('.sidebar-account');
    const sidebarForgot = document.getElementById('sidebar-forgot');
    const closeCartButton = document.getElementById('close-cart');
    const closeAccountButton = document.getElementById('close-account');
    const closeForgotButton = document.getElementById('close-forgot');
    const blurEffect = document.querySelectorAll('.blur');

    // Function to give blur effect
    function toggleBlur() {
        blurEffect.forEach(element => {
            element.classList.toggle('activeblur');
        });
    }

    // Function to remove blur effect
    function removeBlur() {
        blurEffect.forEach(element => {
            element.classList.remove('activeblur');
        });
    }

    burgerMenu.addEventListener('click', () => {
        navbarMenu.classList.toggle('active');
        burgerMenu.classList.toggle('active');
    });

    closeButton.addEventListener('click', () => {
        navbarMenu.classList.remove('active');
        burgerMenu.classList.remove('active');
    });

    // 2.Account, cart, and forgot sidebar:

    // Button to open sidebar cart (Destkop)
    cartButton.addEventListener('click', () => {
        sidebarCart.classList.toggle('active');
        toggleBlur();
    });

    // Button to open sidebar cart (Mobile) 
    cartButtonMobile.addEventListener('click', () => {
        sidebarCart.classList.toggle('active');
        toggleBlur();
    });
    
    // Button to open sidebar account (Destkop)
    accountButton.addEventListener('click', () => {
        sidebarAccount.classList.toggle('active')
        toggleBlur();
    });

    // Button to open sidebar account (Mobile)
    accountButtonMobile.addEventListener('click', () => {
        sidebarAccount.classList.toggle('active');
        toggleBlur();
    });

    // Button to open sidebar forgot password 
    forgotButton.addEventListener('click', () => {
        sidebarForgot.classList.toggle('active')
    });

    // Cart sidebar close button
    closeCartButton.addEventListener('click', () => {
        sidebarCart.classList.remove('active');
        removeBlur();
    });

    // Account sidebar close button
    closeAccountButton.addEventListener('click', () => {
        sidebarAccount.classList.remove('active');
        removeBlur();
    });

    // Forgot sidebar close button 
    closeForgotButton.addEventListener('click', () => {
        sidebarForgot.classList.remove('active');
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
})