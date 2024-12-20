<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SuShoes</title>
    <link rel="stylesheet" href="style.css">
    <!-- JQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="icon" href="../assets/brand-logo.png" type="image/png" />
</head>
<body>
    <!-- Navigation Bar Start-->
    <nav class="navbar fade-in blur">
        <div class="navbar-logo">
            <a href="../index.html">
                <img src="../assets/brand-logo.png" id="navbar-logo">    
            </a>
        </div>
        <div class="navbar-menu">
            <div class="close-button" id="close-button">&times;</div>
            <ul>
                <li><h3>Administration</h3></a></li>
            </ul>
            <!-- Mobile Icons -->
            <div class="mobile-icons">
                <a><a href="../index.html" id="logout-button"><img class="icon" src="../assets/logout.png"></div></a> </a>
            </div>
        </div>        
        <!-- Destkop Icons -->
        <div class="icons">
            <a><a href="../index.html" id="logout-button"><img class="icon" src="../assets/logout.png"></div></a> </a>
        </div>
        <div class="burger-menu" id="burger-menu">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>
    <!-- Navigation Bar End -->

    <!-- Admin Content Start -->
    <div class="admin-page">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="title">SuStore Admin</div>
      <ul class="menu">
        <li class="menu-item active" id="home">Home</li>
        <li class="menu-item" id="orders">Orders</li>
        <li class="menu-item" id="products">Products</li>
        <li class="menu-item" id="rating">Rating</li>
        <li class="menu-item" id="accounts">Accounts</li>
        <li class="menu-item" id="transactions">Transactions</li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="content-container" id="content-home">
        <h1>Welcome to the Admin Panel</h1>
        <p>This is the default dashboard view.</p>
      </div>
      <div class="content-container hidden" id="content-orders">
        <h1>Orders</h1>
        <p>Manage and view orders here.</p>
      </div>
      <div class="content-container hidden" id="content-products">
        <h1>Products</h1>
        <p>Manage and view products here.</p>
      </div>
      <div class="content-container hidden" id="content-rating">
        <h1>Ratings</h1>
        <p>Check product reviews and ratings here.</p>
      </div>
      <div class="content-container hidden" id="content-accounts">
        <h1>Accounts</h1>
        <p>Manage user accounts here.</p>
      </div>
      <div class="content-container hidden" id="content-transactions">
        <h1>Transactions</h1>
        <p>View transaction history here.</p>
      </div>
    </main>
  </div>
    <!-- Admin Content End -->

    <footer class="footer fade-in blur">
        <div class="footer-content">
            <div class="logo">
                <img src="../assets/brand-logo.png"/>
            </div>
        </div>
        <div class="copyright">
            Copyright &copy; 2024 SuShoes Co.
        </div>
    </footer>
    <!-- Footer End -->
    <script src="script.js"></script>
</body>
</html>