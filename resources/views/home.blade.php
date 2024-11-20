<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuShoes | Shoe Store</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <!-- JQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Icon for title bar -->
    <link rel="icon" href="{{asset('img/brand-logo.png') }}"
    type="image/png" />
</head>
<body>
    <!-- Navigation Bar Start-->
    <nav class="navbar fade-in blur">
        <div class="navbar-logo">
            <a href="index.html">
                <img src="assets/brand-logo.png" id="navbar-logo">    
            </a>
        </div>
        <div class="navbar-menu">
            <div class="close-button" id="close-button">&times;</div>
            <ul>
                <li><a href="Products/index.html"><h3>Products</h3></a></li>
                <li><a href="Products/indexmale.html"><h3>Male</h3></a></li>
                <li><a href="Products/indexfemale.html"><h3>Female</h3></a></li>
                <li><a href="Contact/index.html"><h3>Contact</h3></a></li>
            </ul>
            <!-- Mobile Icons -->
            <div class="mobile-icons">
                <a href=""><div class="icon-container"><a id="account-button-mobile"><img class="icon" src="../assets/account.png"></div></a></a>
                <a href=""><div class="icon-container"><a id="cart-button-mobile"><img class="icon" src="../assets/cart.png"></div></a></a>
            </div>
        </div>        
        <!-- Destkop Icons -->
        <div class="icons">
            <a href=""><div class="icon-container"><a id="account-button"><img class="icon" src="assets/account.png"></div></a> </a>
            <a href=""><div class="icon-container"><a id="cart-button"><img class="icon" src="assets/cart.png"></div></a> </a>
        </div>
        <div class="burger-menu" id="burger-menu">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>
    <!-- Navigation Bar End -->

    <!-- Sidebars Start -->
    <div class="sidebar-cart" id="sidebar-cart">
        <div class="sidebar-container">
            <button class="close-sidebar" id="close-cart">&times;</button> 
            <h3>SHOPPING CART</h3>
            <hr class="divider">
            <ul class="cart-items">
                <!-- Will be filled using javascript -->
            </ul>
            <h3 class="cart-total"></h3> 
            <!-- Will be set using javascript -->    
        </div>
    </div>

    <div class="sidebar-account" id="sidebar-account">
        <div class="sidebar-container">
            <button class="close-sidebar" id="close-account">&times;</button> 
            <form action="{{ route('login.process') }}" method="POST" id="account-form">
                @csrf
                <h3>LOGIN</h3>
                <hr class="divider">
                <ul>
                <li>
                    @error('email')
                        <p>{{ $message }}</p>
                    @enderror
                    <input type="email-account" id="email" name="email" placeholder="Email" required>
                </li>
                <li>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </li>
                <li>
                    <a href="#" id="forgot-button">Forgot your password?</a>
                </li>
                <li>
                    <button type="submit" form="account-form" id="login">Login</button>
                </li>
                <li>
                    <a href="{{ route('register') }}" id="create-account">New customer? Create a new account</a>
                </li>
                <li>
                    <a href="AdminLogin/index.html" id="admin-login">Admin Login</a>
                    </li>
                </ul>    
            </form>
        </div>
    </div>

    <div class="sidebar-forgot" id="sidebar-forgot">
        <div class="sidebar-container">
            <button class="close-sidebar" id="close-forgot">&times;</button> 
            <h3>RESET PASSWORD</h3>
            <hr class="divider">
            <p>Lost your password? Please enter your email address. You will receive a link to create a new password via email.</p>
            <ul>
                <li>
                    <input type="email-account" id="email-account" name="email-account" placeholder="Email" required>
                </li>
                <li>
                    <button type="submit" form="account-form" id="reset">Reset Password</button>
                </li>
            </ul>    
        </div>
    </div>
    <!-- Sidebars End -->

    <!-- Hero Start -->
    <div class="hero fade-in blur">
        <div class="carousel-hero">
            <img src="{{ asset('assets/img1hero.JPG') }}" alt="Image 1">
            <img src="{{ asset('assets/img2hero.jpg') }}" alt="Image 2">
            <img src="{{ asset('assets/img3hero.jpg') }}" alt="Image 3">
        </div>
        <button class="prev" onclick="prevSlide()">❮</button>
        <button class="next" onclick="nextSlide()">❯</button>
    </div>
    <!-- Hero End -->

    <!-- History Start -->
    <div class="history fade-in blur">
        <h2>Timeless Craftsmanship Since 1989</h2>
        <h3>Based in Bandung since 1989, crafted for the discerning individual who values timeless style, 
            our shoe store has been dedicated to creating classic, formal, 
            and elegant footwear. Every pairs we offer is the result of meticulous craftsmanship, 
            blending tradition with modern techniques to deliver quality.</h3>
    </div>
    <!-- History End -->

    <!-- Shoemaking Images Start -->
    <div class="shoemaking fade-in blur">
        <img class="shoemaking-img" src="{{ asset('assets/img1history.jpg') }}">
        <img class="shoemaking-img" src="{{ asset('assets/img2history.jpg') }}">
    </div>
    <!-- Shoemaking Images End -->

    <!-- Products Start -->
    <div class="products fade-in blur">
        <div class="latest-product">
            <div class="latest-product-title">
                <span>Our Latest Product</span>    
            </div>
            <div class="products-container">
                <div class="product">
                    <a href ="Products/officer-shoe/produk11.html">
                        <img class="featured-img" src="{{ asset('assets/img1featured.jpg') }}">    
                    </a>
                    <a href="Products/officer-shoe/produk11.html">
                        <h4>Officer Shoes - Black</h4>    
                    </a>
                </div>
                <div class="product">
                    <a href="Products/legetant/produk7.html">
                        <img class="featured-img" src="{{ asset('assets/img2featured.jpg') }}">    
                    </a>
                    <a href="Products/legetant/produk7.html">
                        <h4>Legatant - Waxed</h4>    
                    </a>
                </div>
                <div class="product">
                    <a href="Products/Marine-dress-boots/produk9.html">
                        <img class="featured-img" src="{{ asset('assets/img3featured.jpg') }}">    
                    </a>
                    <a href="Products/Marine-dress-boots/produk9.html">
                        <h4>Marine Dress Shoe - Shell</h4>    
                    </a>
                </div>
            </div>
        </div>
        <div class="products-carousel">
            <!-- Buttons for destkop view only -->
            <div class="products-carousel-buttons">
                <button class="products-carousel-button prev-products" onclick="nextProductCarousel()">❮</button>
                <button class="products-carousel-button next-products" onclick="prevProductCarousel()">❯</button>
            </div>
            <div class="multi-carousel">
                <a href="Products/liberty-boots/produk8.html" class="product-img"><img src="{{ asset('assets/img1.jpg') }}"></a>
                <a href="Products/cordmaster-shoe/produk4.html" class="product-img"><img src="{{ asset('assets/img2.jpg') }}"></a>
                <a href="Products/regent-boots/produk12.html" class="product-img"><img src="{{ asset('assets/img3.jpg') }}"></a>
                <a href="Products/Sylt-Pump-In-Black-Brushed-Leather/produk13.html" class="product-img"><img src="{{ asset('assets/img4.jpg') }}"></a>
                <a href="Products/Sylt-Slingback-Pump-In-Light-Beige-Nappa-Leather/produk19.html" class="product-img"><img src="{{ asset('assets/img5.jpg') }}"></a>
                <a href="Products/Ballyrina-Mary-Jane-Pump-In-Black-Leather/produk17.html" class="product-img"><img src="{{ asset('assets/img6.jpg') }}"></a>
                <a href="Products/Kerbs-Driver-In-White-Leather/produk22.html" class="product-img"><img src="{{ asset('assets/img7.jpg') }}"></a>
                <a href="Products/Ballyrina-Flat-In-Black-Leather/produk23.html" class="product-img"><img src="{{ asset('assets/img8.jpg') }}"></a>
            </div>

             <!-- Slidebar for mobile/tablet view only-->
            <input type="range" id="carousel-slider" min="0" max="100" value="0" class="slider">
        </div>
    </div>
    <!-- Products End -->

    <!-- Interesting Points Start -->
    <div class="ip fade-in blur">
        <div class="row-ip">
            <div class="img-ip-container">
                <img class="img-ip" src="{{ asset('assets/ip_img1.jpg') }}">
                <div class="img-ip-text">
                    <h3>QUALITY</h3>
                </div>
            </div>
            <div class="img-ip-container">
                <img class="img-ip" src="{{ asset('assets/ip_img2.jpg') }}">
                <div class="img-ip-text">
                    <h3>COMFORT</h3>
                </div> 
            </div>
        </div>
        <div class="row-ip">
            <div class="img-ip-container">
                <img class="img-ip" id="img-ip-spesific" src="{{ asset('assets/ip_img3.jpg') }}">
                <div class="img-ip-text" id="spesific-img-text">
                    <h3>STYLE</h3>
                </div> 
            </div>
            <div class="img-ip-container">
                <img class="img-ip" src="{{ asset('assets/ip_img4.jpg') }}"> 
                <div class="img-ip-text">
                    <h3>ELEGANCE</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Interesting Points End -->

    <!-- Footer Start -->
    <footer class="footer fade-in blur">
        <div class="footer-content">
            <div class="logo">
                <img src="assets/brand-logo.png"/>
            </div>
            <div class="footer-menu">
                <a href="Products/index.html" class="footer-link">Products</a>
                <a href="/Products/indexmale.html" class="footer-link">Male</a>
                <a href="/Products/indexfemale.html" class="footer-link">Female</a>
                <a href="Contact/index.html" class="footer-link">Contact</a>
            </div>
            <div class="social">
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="assets/instagram.png"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="assets/twitter.png"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="assets/whatsapp.png"/></a>    
                </div>
            </div>
        </div>
        <div class="copyright">
            Copyright &copy; 2024 SuShoes Co.
        </div>
    </footer>
    <!-- Footer End -->
    <script src="{{ asset('js/home.js') }}"></script>
    
</body>
</html>