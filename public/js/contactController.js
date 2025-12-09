app.controller('ContactController', function($scope, $timeout, $routeParams, $http) {
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

    $scope.contactData = {
        first_name: '',
        last_name: '',
        work_email: '',
        message: '',
    };

    $scope.errorMessageForm = '';
    $scope.successMessageForm = '';

    $scope.contact = function() {
        $http.post('/api/contact', $scope.contactData)
        .then(function(response) {
            $scope.successMessageForm = response.data.message;
            $scope.errorMessageForm = '';
            $scope.contactData = {}; 
        })
        .catch(function(error) {
            if (error.data && error.data.errors) {
                $scope.errorMessageForm = error.data.errors; 
            } else {
                $scope.errorMessageForm = 'An error occurred. Please try again.';
            }
            $scope.successMessageForm = '';
        });
    };

    // SIDEBAR ACCOUNT START
    
    // Initialization
    $scope.userId = null; 
    $scope.showLoginForm = true; 
    $scope.accountInfo = {};
    
    $scope.errorMessage = '';
    $scope.successMessage = '';
    $scope.loginData = {}; 

    // Check Login Status & Get Account Info
    $scope.checkLoginStatus = function() {
        $http.get('/api/account-info')
            .then(function(response) {
                // User is logged in
                $scope.accountInfo = response.data.account;
                $scope.userId = response.data.account._id; 
                $scope.showLoginForm = false; 
            
                $scope.getCartItems();
            })
            .catch(function(error) {
                // User is NOT logged in 
                $scope.showLoginForm = true; 
                $scope.userId = null;

                $scope.cartItems = [];
                $scope.cartTotal = 0;
            });
    };

    // Login Function 
    $scope.login = function() {
        const routeName = 'contact'; 
        
        $http.post('/api/login', {
            email: $scope.loginData.email,     
            password: $scope.loginData.password,
            redirect_route: routeName
        })
        .then(function(response) {
            $scope.successMessage = response.data.message;
            $scope.errorMessage = '';
            $scope.loginData = {}; 

            // Redirect logic
            if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
            } else {
                // Reload the account info
                $scope.checkLoginStatus();
            }
        })
        .catch(function(error) {
            console.error('Login Error:', error);
            if (error.data && error.data.errors) {
                // Handle Laravel validation errors array
                $scope.errorMessage = Object.values(error.data.errors).flat().join(' ');
            } else if (error.data && error.data.message) {
                $scope.errorMessage = error.data.message;
            } else {
                $scope.errorMessage = 'An error occurred. Please try again.';
            }
            $scope.successMessage = '';
        });
    }

    // Logout Function 
    $scope.logout = function() {
        $http.post('/api/logout')
            .then(function(response) {
                // On success, reset state to guest mode
                $scope.userId = null;
                $scope.accountInfo = {};
                $scope.showLoginForm = true;
                window.location.href = '/';
            });
    }

    // Checking if user is already logged in
    $scope.checkLoginStatus();

    // SIDEBAR ACCOUNT END

    // SIDEBAR CART START

    $scope.cartItems = [];
    $scope.cartTotal = 0;

    // Getting cartItems from the database
    $scope.getCartItems = function() {
        $http.post('/api/get-cart-items')
            .then(function(response) {
                if (response.data.items && response.data.items.length > 0) {
                    // Map database items to the format used in the frontend
                    $scope.cartItems = response.data.items.map(item => ({
                        id: item.product_id,
                        name: item.name , 
                        price: item.price,
                        img1: item.img1, 
                        quantity: item.quantity
                    }));

                    // Calculate total
                    $scope.cartTotal = $scope.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
                } else {
                    // If no items, initialize cartItems as empty and set total to 0
                    $scope.cartItems = [];
                    $scope.cartTotal = 0;
                }
            })
            .catch(function(error) {
                console.error('Error fetching cart items:', error);
                alert('Failed to fetch cart items. Please try again later.');
            });
    };

    // Increasing the quantity of the product
    $scope.increaseQuantity = function(item) {
        $http.post('/api/increase-quantity', {
            productId: item.id,
            quantity: 1,
        })
        .then(function(response) {
            if (response.data.message) {
                item.quantity += 1;
                $scope.cartTotal += +item.price;
            } else {
                alert(response.data.error);
            }
        })
        .catch(function(error) {
            console.error('Error increasing quantity:', error);
            alert("The stock is unavailable")
        });
    };
    
    // Decreasing the quantity of the product
    $scope.decreaseQuantity = function(item) {
        if (item.quantity > 1) {
            $http.post('/api/decrease-quantity', {
                productId: item.id,
                quantity: 1,
            })
            .then(function(response) {
                if (response.data.message) {
                    item.quantity -= 1;
                    $scope.cartTotal -= +item.price;
                }
            })
            .catch(function(error) {
                console.error('Error decreasing quantity:', error);
            });
        } else {
            alert('Cannot decrease quantity below 1');
        }
    };
    
    // Remove product from cart
    $scope.removeFromCart = function(product) {
        const data = {
            product_id: product.id
        };

        // Make a POST request to remove from cart
        $http.post('/api/remove-from-cart', data)
            .then(function(response) {
                // Success
                const index = $scope.cartItems.findIndex(item => item.id === product.id);
                if (index !== -1) {
                    $scope.cartTotal -= $scope.cartItems[index].price * $scope.cartItems[index].quantity;
                    $scope.cartItems.splice(index, 1);
                }
                alert('Product removed from cart');
            })
            .catch(function(error) {
                // Handle errors
                console.error('Error removing product from cart:', error);
                if (error.status === 404) {
                    alert('Product not found in the cart.');
                } else {
                    alert('Failed to remove product from the cart. Please try again.');
                }
            });
    };

    $scope.addCartFail = function() {
        alert('Please login to shop our products');
    };

    $scope.checkout = function() {
        if ($scope.cartItems.length === 0) {
            alert("Your cart is empty!");
            return;
        }
    
        $http.post('/api/checkout', {})
            .then(function(response) {
                alert('Order placed successfully!');
                // Clear the cart after successful checkout
                $scope.cartItems = [];
                $scope.cartTotal = 0;
            })
            .catch(function(error) {
                console.error('Error during checkout:', error);
                alert('Failed to place order. Please try again.');
            });
    };

    // SIDEBAR CART END
});
