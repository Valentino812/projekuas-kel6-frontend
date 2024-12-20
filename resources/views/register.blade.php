<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SuShoes</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
            <a><div class="icon-container"><a href="{{ route('home') }}" id="home-button"><img class="icon" src="{{ asset('img/home.png') }}"></div></a> </a>
            </div>
        </div>        
        <!-- Destkop Icons -->
        <div class="icons">
            <a><div class="icon-container"><a href="{{ route('home') }}" id="home-button"><img class="icon" src="{{ asset('img/home.png') }}"></div></a> </a>
        </div>
        <div class="burger-menu" id="burger-menu">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
 
    </nav>
    <!-- Navigation Bar End -->

    <!-- Contact Form Start -->
    <div class="modal fade-in blur">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <h2>Register</h2>
            <p>Welcome! Please fill out the form to register.</p>
            <form action="{{ route('register.create') }}" method="POST">
                @csrf   
                <div class="form-group-inline">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}">
                        @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}">
                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit">Register ></button>
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
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>