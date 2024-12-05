app.controller('HomeController', function($scope, $timeout, $routeParams,  $http) {
    // Using jQuery to change an element's style after the page is loaded
    $scope.$on('$viewContentLoaded', function() {
        // This ensures the DOM is fully loaded before running jQuery
        $('#homeMessage').css('color', 'red');
    });

    // Using jQuery with AngularJS $timeout to trigger after Angular rendering
    $timeout(function() {
        $('#homeMessage').fadeIn();
    }, 500); // Delay to let Angular render first

    // 1.Entrance Transition Start (using jQuery for simpler syntax)
    // Trigger the active class to do the transition for fade-in
    $('.fade-in').each(function(index) {
        $(this).delay(150 * index).queue(function(next) { // 150ms delay between transitions of each element 
            $(this).addClass('active');
            next();
        });
    });
    // 1.Entrance Transition End

    // 2.Navbar and sidebar
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
    // 2.Navbar and sidebar

    // 3.Hero Carousel Start 
    let currentIndex = 0;
    let autoSlideHero;

    function heroCorouselSlide(index) {
        const carousel = document.querySelector('.carousel-hero');
        const totalSlides = document.querySelectorAll('.carousel-hero img').length;

        if (index >= totalSlides) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalSlides - 1;
        } else {
            currentIndex = index;
        }

        const offset = -currentIndex * 100;
        carousel.style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
        heroCorouselSlide(currentIndex + 1);
    }

    function prevSlide() {
        heroCorouselSlide(currentIndex - 1);
    }

    // Resetting the hero carousel auto slide interval
    function resetAutoSlide() {
        clearInterval(autoSlideHero); 
        autoSlideHero = setInterval(nextSlide, 8000); 
    }

    // Hero carousel slides automatically every 8 seconds
    autoSlideHero = setInterval(nextSlide, 8000);

    // Reset interval when button is clicked
    document.querySelector('.next').addEventListener('click', () => {
        nextSlide();
        resetAutoSlide();  
    });

    // Reset interval when button is clicked
    document.querySelector('.prev').addEventListener('click', () => {
        prevSlide();
        resetAutoSlide();  
    });
    // 3.Hero Carousel End


    // 4.Product Carousel Start

    let currentProductIndex = 0;
    const productCarousel = document.querySelector('.multi-carousel');
    const productItems = document.querySelectorAll('.product-img');
    const totalProductItems = productItems.length;
    const visibleItems = 4; // Visible number of products at a time
    const itemWidth = productItems[0].offsetWidth + 10; // Width of each image including the gap

    function updateProductCarousel() {
        const offset = -currentProductIndex * itemWidth;
        productCarousel.style.transform = `translateX(${offset}px)`;
    }

    // Function for destkop only next carousel button
    function nextProductCarousel() {
        if (currentProductIndex < totalProductItems - visibleItems) {
            currentProductIndex++;
            updateProductCarousel();
        } else {
            currentProductIndex = 0; 
            updateProductCarousel();
        }
    }

    // Function for destkop only prev carousel button
    function prevProductCarousel() {
        if (currentProductIndex > 0) {
            currentProductIndex--;
            updateProductCarousel();
        } else {
            currentProductIndex = totalProductItems - visibleItems; 
            updateProductCarousel();
        }
    }

    // Event listeners to product carousel buttons
    document.querySelector('.products-carousel-buttons .next-products').addEventListener('click', () => {
        nextProductCarousel();
    });

    document.querySelector('.products-carousel-buttons .prev-products').addEventListener('click', () => {
        prevProductCarousel();
    });

    // Carousel slider for smartphone/tablet:

    // Selecting the slider
    const carouselSlider = document.querySelector('#carousel-slider');

    // Set max value of slider based on the number of products (2 per view for mobile and tablet)
    carouselSlider.max = totalProductItems - 2;

    // Update carousel when slider is moved
    carouselSlider.addEventListener('input', () => {
        currentProductIndex = Math.round(carouselSlider.value); 
        updateProductCarousel();
    });

    // Update slider position when carousel is used
    function updateProductCarousel() {
        const offset = -currentProductIndex * itemWidth;
        productCarousel.style.transform = `translateX(${offset}px)`;
        carouselSlider.value = currentProductIndex; // Syncronizing the slider value with the carousel
    }
    // 4.Product Carousel End


    // SIDEBAR ACCOUNT START
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

    // SIDEBAR ACCOUNT END

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
