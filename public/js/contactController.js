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
            $scope.contactData = {}; // Reset form fields
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

    // LOGIN
    // Check if the 'id' is part of the route
    $scope.userId = $routeParams.id;

    // Derterment what to show on sidebar account (login form or account info)
    $scope.showLoginForm = !$scope.userId;

    $scope.errorMessage = '';
    $scope.successMessage = '';

    $scope.login = function() {
        const routeName = 'contactLogin'; 
        $http.post('/api/login', {
            email: $scope.login.email,
            password: $scope.login.password,
            redirect_route: routeName
        })
        .then(function(response) {
            $scope.successMessage = response.data.message;;
            $scope.errorMessage = '';
            $scope.login = {};

            // Redirect user to the provided URL
            if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            if (error.data && error.data.errors) {
                $scope.errorMessage = Object.values(error.data.errors).join(' ');
            } else if (error.data && error.data.message) {
                $scope.errorMessage = error.data.message;
            } else {
                $scope.errorMessage = 'An error occurred. Please try again.';
            }
            $scope.successMessage = '';
        });
    }

    if($scope.userId){
        $scope.getAccountInfo = function(userId) {
            // console.log('Fetching Account Info for User ID:', userId);
        
            $http.get('/api/account-info/' + userId)
                .then(function(response) {
                    // console.log('Response from API:', response); 
                    $scope.accountInfo = response.data.account;
                    // console.log('Account Info:', $scope.accountInfo); 
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

    // SIDEBAR CART START

    $scope.cartItems = [];
    $scope.cartTotal = 0;

    // Getting cartItems from the database
    $scope.getCartItems = function() {
        const data = {
            userId: $scope.userId
        };

        $http.post('/api/get-cart-items', data)
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

    // Get cart items is user has login
    if($scope.userId){
        // Fetch cart items on load
        $scope.getCartItems();  
    }

    
    // Increasing the quantity of the product
    $scope.increaseQuantity = function(item) {
        $http.post('/api/increase-quantity', {
            productId: item.id,
            quantity: 1,
            userId: $scope.userId
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
                userId: $scope.userId
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
            userId: $scope.userId,
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
    
        const orderData = {
            userId: $scope.userId,
        };
    
        $http.post('/api/checkout', orderData)
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
