<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - SuShoes</title>
    <link rel="stylesheet" href="style.css">
    <!-- JQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href=
        "../assets/brand-logo.png"
    type="image/png" />
</head>
<body>
    <!-- Search Popup -->
    <div id="search-popup" class="search-popup" style="display:none;">
        <span class="close-popup">&times;</span>
        <input type="text" id="search-input" placeholder="Search products...">
    </div>

    <!-- Navigation Bar Start-->
    <nav class="navbar fade-in blur">
        <div class="navbar-logo">
            <a href ="../index.html">
                <img src ="../assets/brand-logo.png" id="navbar-logo">    
            </a>
        </div>
        <div class="navbar-menu">
            <ul>
                <li>
                    <a href="../Products/index.html"><h3>Products</h3></a>
                </li>
                <li>
                    <a href="indexmale.html"><h3>Male</h3></a>
                </li>
                <li>
                    <a href="indexfemale.html"><h3>Female</h3></a>
                </li>
                <li>
                    <a href="../Contact/index.html"><h3>Contact</h3></a>
                </li>
            </ul>
            <div class="mobile-icons">
                <!-- Search -->
                <input type="text" id="navbar-mobile-search-input" placeholder="Search products..." class="search-field">
                <a href=""><div class="icon-container"><a id="account-button-mobile"><img class="icon" src="../assets/account.png"></div></a></a>
                <a href=""><div class="icon-container"><a id="cart-button-mobile"><img class="icon" src="../assets/cart.png"></div></a></a>
            </div>
        </div>        

        <div class="icons">
            <!-- Search -->
            <input type="text" id="navbar-search-input" placeholder="Search products..." class="search-field">
            <!-- Account -->
            <a href=""><div class="icon-container"><a id="account-button"><img class="icon" src="../assets/account.png"></div></a> </a>
            <!-- Cart -->
            <a href=""><div class="icon-container"><a id="cart-button"><img class="icon" src="../assets/cart.png"></div></a> </a>
        </div>
        <div class="burger-menu burger" id="burger-menu">
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
                    <a href="Register/index.html" id="create-account">New customer? Create a new account</a>
                </li>
                <li>
                    <a href="AdminLogin/index.html" id="admin-login">Admin Login</a>
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

    <!-- Search Results -->
    <div id="search-results" class="search-results" style="display:none;">
        <ul id="results-list"></ul>
    </div>
    <!-- Hero Start -->
    <div class="hero fade-in blur">
        <div class="carousel-hero">
            <img src="../assets/hero-image1.jpg" alt="Boots">
            <img src="../assets/hero-image2.jpg" alt="Boots">
            <img src="../assets/hero-image3.jpg" alt="Boots">
        </div>
        <button class="prev" onclick="prevSlide()">❮</button>
        <button class="next" onclick="nextSlide()">❯</button>
        <div class="hero-text">
            <h1>READY TO WEAR</h1>
            <p>Our seasonal prêt-à-porter creation, from the start to the latest available collection in stock. We introduced our newest articles, materials and details through these collections.</p>
        </div>
    </div>
    <!-- Hero End -->
    <div class="sort-container fade-in blur">
        <select id="sort-select">
            <option value="">Sort By</option>
            <option value="price">Price: High to Low</option>
            <option value="price-low-to-high">Price: Low to High</option>
            <option value="alphabetical">Alphabetical Order</option>
            <option value="reverse-alphabetical">Reverse Alphabetical Order</option>
        </select>
    </div>

    <section class="products fade-in blur">
        <div class="product">
            <a href="bedrock/produk1.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product1.webp" alt="Product 1" class="main-image">
                    
                    <img src="../assets/product1-hover.webp" alt="Product 1 Hover" class="hover-image">
                </div>
                <h2>Bedrock</h2>
                <p>Rp 5.000.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 2 -->
        <div class="product">
            <a href="Boonodocers/produk2.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product2.webp" alt="Product 2" class="main-image">
                    <img src="../assets/product2-hover.webp" alt="Product 2 Hover" class="hover-image">
                </div>
                <h2>Boondockers</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 3 -->
        <div class="product">
            <a href="cord-master/produk3.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product3.webp" alt="Product 3" class="main-image">
                    <img src="../assets/product3-hover.webp" alt="Product 3 Hover" class="hover-image">
                </div>
                <h2>Cordmaster</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 4 -->
        <div class="product">
            <a href="cordmaster-shoe/produk4.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product4.webp" alt="Product 4" class="main-image">
                    <img src="../assets/product4-hover.webp" alt="Product 4 Hover" class="hover-image">
                </div>
                <h2>Cordmaster Shoe</h2>
                <p>Rp 4.900.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 5 -->
        <div class="product">
            <a href="cordmaster-shorty/produk5.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product5.webp" alt="Product 5" class="main-image">
                    <img src="../assets/product5-hover.webp" alt="Product 5 Hover" class="hover-image">
                </div>
                <h2>Cordmaster Shorty</h2>
                <p>Rp 5.200.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 6 -->
        <div class="product">
            <a href="legacy-x/produk6.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product6.webp" alt="Product 6" class="main-image">
                    <img src="../assets/product6-hover.webp" alt="Product 6 Hover" class="hover-image">
                </div>
                <h2>Legacy X</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 7 -->
        <div class="product">
            <a href="legetant/produk7.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product7.webp" alt="Product 7" class="main-image">
                    <img src="../assets/product7-hover.webp" alt="Product 7 Hover" class="hover-image">
                </div>
                <h2>Legatant</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 8 -->
        <div class="product">
            <a href="liberty-boots/produk8.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product8.webp" alt="Product 8" class="main-image">
                    <img src="../assets/product8-hover.webp" alt="Product 8 Hover" class="hover-image">
                </div>
                <h2>Liberty Boots</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 9 -->
        <div class="product">
            <a href="marine-dress-boots/produk9.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product9.webp" alt="Product 9" class="main-image">
                    <img src="../assets/product9-hover.webp" alt="Product 9 Hover" class="hover-image">
                </div>
                <h2>Marine Dress Boots</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 10 -->
        <div class="product">
            <a href="norris/produk10.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product10.webp" alt="Product 10" class="main-image">
                    <img src="../assets/product10-hover.jpg" alt="Product 10 Hover" class="hover-image">
                </div>
                <h2>Norris</h2>
                <p>Rp 5.000.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 11 -->
        <div class="product">
            <a href="officer-shoe/produk11.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product11.webp" alt="Product 11" class="main-image">
                    <img src="../assets/product11-hover.webp" alt="Product 11 Hover" class="hover-image">
                </div>
                <h2>Officer Shoes</h2>
                <p>Rp 4.700.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 12 -->
        <div class="product">
            <a href="regent-boots/produk12.html" class="product-link">
                <div class="product-image">
                    <img src="../assets/product12.webp" alt="Product 12" class="main-image">
                    <img src="../assets/product12-hover.webp" alt="Product 12 Hover" class="hover-image">
                </div>
                <h2>Regent Boots</h2>
                <p>Rp 5.400.000,00 IDR</p>
            </a>
        </div>
        <!-- Product 13 -->
        <div class="product">
            <a href="Sylt-Pump-In-Black-Brushed-Leather/produk13.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws1.webp" alt="Product 13" class="main-image">
                  <img src="../assets/ws1h.webp" alt="Product 13 Hover" class="hover-image">
              </div>
              <h2>Sylt Pump In Black Brushed Leather</h2>
              <p>Rp 14.480.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 14 -->
          <div class="product">
            <a href="Sylt-Pump-In-Black-Nappa-Leather/produk14.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws2.webp" alt="Product 14" class="main-image">
                  <img src="../assets/ws2h.webp" alt="Product 14 Hover" class="hover-image">
              </div>
              <h2>Sylt Pump In Black Nappa Leather</h2>
              <p>Rp 15.580.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 15 -->
          <div class="product">
            <a href="Peggy-Boot-in-Black-Leather/produk15.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws3.webp" alt="Product 15" class="main-image">
                  <img src="../assets/ws3h.webp" alt="Product 15 Hover" class="hover-image">
              </div>
              <h2>Peggy Boot in Black Leather</h2>
              <p>Rp 24.980.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 16 -->
          <div class="product">
            <a href="Daily-Emblem-Pump-in-Black-Patent-Leather/produk16.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws4.webp" alt="Product 16" class="main-image">
                  <img src="../assets/ws4h.webp" alt="Product 16 Hover" class="hover-image">
              </div>
              <h2>Daily Emblem Pump in Black Patent Leather</h2>
              <p>Rp 15.880.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 17 -->
          <div class="product">
            <a href="Ballyrina-Mary-Jane-Pump-In-Black-Leather/produk17.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws5.webp" alt="Product 17" class="main-image">
                  <img src="../assets/ws5h.webp" alt="Product 17 Hover" class="hover-image">
              </div>
              <h2>Ballyrina Mary-Jane Pump In Black Leather</h2>
              <p>Rp 15.880.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 18 -->
          <div class="product">
            <a href="Sylt-Slingback-Pump-In-Black-Nappa-Leather/produk18.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws6.webp" alt="Product 18" class="main-image">
                  <img src="../assets/ws6h.webp" alt="Product 18 Hover" class="hover-image">
              </div>
              <h2>Sylt Slingback Pump In Black Nappa Leather</h2>
              <p>Rp 14.980.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 19 -->
          <div class="product">
            <a href="Sylt-Slingback-Pump-In-Light-Beige-Nappa-Leather/produk19.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws7.webp" alt="Product 19" class="main-image">
                  <img src="../assets/ws7h.webp" alt="Product 19 Hover" class="hover-image">
              </div>
              <h2>Sylt Slingback Pump In Light Beige Nappa Leather</h2>
              <p>Rp 14.980.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 20 -->
          <div class="product">
            <a href="Plume-Moccasin-In-Black-Leather/produk20.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws8.webp" alt="Product 20" class="main-image">
                  <img src="../assets/ws8h.webp" alt="Product 20 Hover" class="hover-image">
              </div>
              <h2>Plume Moccasin In Black Leather</h2>
              <p>Rp 18.380.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 21 -->
          <div class="product">
            <a href="Kerbs-Driver-In-Black-Leather/produk21.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws9.webp" alt="Product 21" class="main-image">
                  <img src="../assets/ws9h.webp" alt="Product 21 Hover" class="hover-image">
              </div>
              <h2>Kerbs Driver In Black Leather</h2>
              <p>Rp 13.480.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 22 -->
          <div class="product">
            <a href="Kerbs-Driver-In-White-Leather/produk22.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws10.webp" alt="Product 22" class="main-image">
                  <img src="../assets/ws10h.webp" alt="Product 22 Hover" class="hover-image">
              </div>
              <h2>Kerbs Driver In White Leather</h2>
              <p>Rp 13.480.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 23 -->
          <div class="product">
            <a href="Ballyrina-Flat-In-Black-Leather/produk23.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws11.webp" alt="Product 23" class="main-image">
                  <img src="../assets/ws11h.webp" alt="Product 23 Hover" class="hover-image">
              </div>
              <h2>Ballyrina Flat In Black Leather</h2>
              <p>Rp 14.480.000,00 IDR</p>
            </a>
          </div>
          <!-- Product 24 -->
          <div class="product">
            <a href="Daily-Emblem-Loafers-In-Black-Leather/produk24.html" class="product-link">
              <div class="product-image">
                  <img src="../assets/ws12.webp" alt="Product 24" class="main-image">
                  <img src="../assets/ws12h.webp" alt="Product 24 Hover" class="hover-image">
              </div>
              <h2>Daily Emblem Loafers In Black Leather</h2>
              <p>Rp 14.980.000,00 IDR</p>
            </a>
          </div>
    </section>

    <footer class="footer fade-in blur">
        <div class="footer-content">
            <div class="logo">
                <img src="../assets/brand-logo.png"/>
            </div>
            <div class="footer-menu">
                <a href="index.html" class="footer-link">Products</a>
                <a href="indexmale.html" class="footer-link">Male</a>
                <a href="indexfemale.html" class="footer-link">Female</a>
                <a href="../Contact/index.html" class="footer-link">Contact</a>
            </div>
            <div class="social">
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="../assets/instagram.png"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="../assets/twitter.png"/></a>    
                </div>
                <div class="social-icon-container">
                    <a href="" target="_blank" class="social-icon"><img src="../assets/whatsapp.png"/></a>    
                </div>
            </div>
        </div>
        <div class="copyright">
            Copyright &copy; 2024 SuShoes Co.
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
