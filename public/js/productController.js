app.controller('ProductController', function($scope, $timeout, $routeParams, $http) {
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


    const configSections = document.querySelectorAll('.config-section');

    configSections.forEach(section => {
        const images = section.querySelectorAll('img');

        images.forEach(image => {
            image.addEventListener('click', () => {
                images.forEach(img => img.classList.remove('selected'));
                image.classList.add('selected');
            });
        });
    });

    // Menangani perubahan pada select (opsional)
    const selects = document.querySelectorAll('.config-section select');

    selects.forEach(select => {
        select.addEventListener('change', (e) => {
            console.log(`Pilihan diubah menjadi: ${e.target.value}`);
        });
    });

    // Handler for SHOE LAST
    const shoeLastImages = document.querySelectorAll('.shoe-last-option');
    const shoeLastPreview = document.getElementById('shoe-last-preview');

    shoeLastImages.forEach(img => {
        img.addEventListener('click', () => {
            shoeLastImages.forEach(image => image.classList.remove('selected'));
            img.classList.add('selected');
            const description = img.querySelector('img').getAttribute('data-description');
            shoeLastPreview.innerHTML = description;
        });

        img.addEventListener('mouseenter', () => {
            const src = img.querySelector('img').src.replace('-thumb', '');
            shoeLastPreview.innerHTML = `<img src="${src}" alt="Shoe Last Preview" />`;
            shoeLastPreview.style.display = 'block';
            shoeLastPreview.style.left = `${img.getBoundingClientRect().left}px`;
            shoeLastPreview.style.top = `${img.getBoundingClientRect().top + img.offsetHeight}px`;
        });

        img.addEventListener('mouseleave', () => {
            shoeLastPreview.style.display = 'none';
        });
    });

    // Handler for TOE BOX
    const toeBoxImages = document.querySelectorAll('.toe-box-option img');
    const toeBoxPreview = document.getElementById('toe-box-preview');

    toeBoxImages.forEach(img => {
        img.addEventListener('click', () => {
            toeBoxImages.forEach(image => image.classList.remove('selected'));
            img.classList.add('selected');
            const description = img.getAttribute('data-description'); 
            toeBoxPreview.innerHTML = description; 
        });

        img.addEventListener('mouseenter', () => {
            const src = img.src.replace('-thumb', ''); 
            toeBoxPreview.innerHTML = `<img src="${src}" alt="Toe Box Preview" />`;
            toeBoxPreview.style.display = 'block';
            toeBoxPreview.style.left = `${img.getBoundingClientRect().left}px`; 
            toeBoxPreview.style.top = `${img.getBoundingClientRect().top + img.offsetHeight}px`; 
        });

        img.addEventListener('mouseleave', () => {
            toeBoxPreview.style.display = 'none';
        });
    });

     // Sidebars Start
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
     // Sidebars End

    // 5.Login
    
    // Check if the 'id' is part of the route
    $scope.userId = $routeParams.id;

    // console.log('Account ID:', $scope.userId);

    // Derterment what to show on sidebar account (login form or account info)
    $scope.showLoginForm = !$scope.userId;

    $scope.errorMessage = '';
    $scope.successMessage = '';

    $scope.login = function() {
        const routeName = 'homeLogin'; 
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

    // Initialize product data
    $scope.product = {};
    $scope.error = null;

    // Get product ID from route parameters
    var productId = $routeParams.productid;

    // Fetch product details
    $http.get('/api/product/' + productId)
        .then(function(response) {
            // Success: Assign product data to scope
            $scope.product = response.data.product;
        })
        .catch(function(error) {
            // Handle errors
            if (error.status === 404) {
                $scope.error = 'Product not found.';
            } else {
                $scope.error = 'An error occurred while fetching the product.';
            }
        });
        
        if ($scope.product.stock > 0) {
            // Handle "Add to Cart" button click
            const addToCartButton = document.getElementById('add-to-cart-button');
            addToCartButton.addEventListener('click', () => {
                alert('Item added to cart!');
            });
        }

    // Function to handle product click
    $scope.addToSidebar = function(product) {
        // Add product to sidebar
        $scope.selectedProduct = product;

        // Send product data to server
        $http.post('/api/add-to-cart', { productId: product.id })
            .then(function(response) {
                alert('Product added to cart!');
            })
            .catch(function(error) {
                console.error('Error adding product to cart:', error);
            });
    };

    $scope.cartItems = [];
    $scope.cartTotal = 0;

    $scope.addToCart = function(product) {
        $scope.cartItems.push(product);
        $scope.cartTotal += product.price;
        alert('Item added to cart!');
    };

    $scope.checkout = function() {
        const orderData = {
            items: $scope.cartItems.map(item => ({
                product_id: item.id,
                price: item.price,
                quantity: 1, // Assuming 1 for simplicity, adjust as needed
                total_price: item.price // Assuming total price is price * quantity
            })),
            total: $scope.cartTotal
        };

        $http.post('/api/checkout', orderData)
            .then(function(response) {
                alert('Order placed successfully!');
                $scope.cartItems = [];
                $scope.cartTotal = 0;
            })
            .catch(function(error) {
                console.error('Error during checkout:', error);
                alert('Failed to place order. Please try again.');
            });
    };

});
