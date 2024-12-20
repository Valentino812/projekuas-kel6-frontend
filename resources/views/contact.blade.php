<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - SuShoes</title>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <!-- JQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="icon" href="{{ asset('img/brand-logo.png') }}" type="image/png" />
</head>
<body>
    <!-- Navigation Bar Start-->
    <nav class="navbar fade-in blur">
        <div class="navbar-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/brand-logo.png') }}" id="navbar-logo">    
            </a>
        </div>
        <div class="navbar-menu">
            <div class="close-button" id="close-button">&times;</div>
            <ul>
                <li><a href="../Products/index.html"><h3>Products</h3></a></li>
                <li><a href="../Products/indexmale.html"><h3>Male</h3></a></li>
                <li><a href="../Products/indexfemale.html"><h3>Female</h3></a></li>
                <li><a href="{{ route('contact') }}"><h3>Contact</h3></a></li>
            </ul>
            <!-- Mobile Icons -->
            <div class="mobile-icons">
                <a href=""><div class="icon-container"><a id="account-button-mobile"><img class="icon" src="{{ asset('img/account.png') }}"></div></a></a>
                <a href=""><div class="icon-container"><a id="cart-button-mobile"><img class="icon" src="{{ asset('img/cart.png') }}"></div></a></a>
            </div>
        </div>        
        <!-- Destkop Icons -->
        <div class="icons">
            <a href=""><div class="icon-container"><a id="account-button"><img class="icon" src="{{ asset('img/account.png') }}"></div></a> </a>
            <a href=""><div class="icon-container"><a id="cart-button"><img class="icon" src="{{ asset('img/cart.png') }}"></div></a> </a>
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
            <h3>LOGIN</h3>
            <hr class="divider">
            <ul>
                <li>
                    <input type="email-account" id="email-account" name="email-account" placeholder="Email" required>
                </li>
                <li>
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
                    <a href="{{ route('adminlogin') }}" id="admin-login">Admin Login</a>
                </li>
            </ul>    
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

    <!-- Contact Form Start -->
    <div class="modal fade-in blur">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <h2>Contact Us</h2>
            <p>We would love to hear from you on our service, products, website, or anything you want to share with us. Please fill the form below</p>
            <form>
                <div class="form-group-inline">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit">Send ></button>
            </form>
        </div>
    </div>

    <footer class="footer fade-in blur">
        <div class="footer-content">
            <div class="logo">
                <img src="{{ asset('img/brand-logo.png') }}"/>
            </div>
            <div class="footer-menu">
                <a href="" class="footer-link">Products</a>
                <a href="" class="footer-link">Male</a>
                <a href="" class="footer-link">Female</a>
                <a href="{{ route('contact') }}" class="footer-link">Contact</a>
            </div>
            <div class="social">
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="{{ asset('img/instagram.png') }}"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="{{ asset('img/twitter.png') }}"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="{{ asset('img/whatsapp.png') }}"/></a>    
                </div>
            </div>
        </div>
        <div class="copyright">
            Copyright &copy; 2024 SuShoes Co.
        </div>
    </footer>
    <!-- Footer End -->
    <script src="{{ asset('js/contact.js') }}"></script>
</body>
</html>