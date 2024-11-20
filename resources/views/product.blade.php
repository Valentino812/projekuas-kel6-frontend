<!DOCTYPE html>
<html>
  <head>
    <title>Ballyrina Flat In Black Leather</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../styleProduct.css" />
      <!-- JQuery script -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href=
        "../../assets/brand-logo.png"
    type="image/png" />
  </head>
  <body>
    <!-- Navigation Bar Start-->
    <nav class="navbar fade-in blur">
        <div class="navbar-logo">
            <a href="../../index.html">
                <img src="../../assets/brand-logo.png" id="navbar-logo">    
            </a>
        </div>
        <div class="navbar-menu">
            <div class="close-button" id="close-button">&times;</div>
            <ul>
                <li><a href="../index.html"><h3>Products</h3></a></li>
                <li><a href="../indexmale.html"><h3>Male</h3></a></li>
                <li><a href="../indexfemale.html"><h3>Female</h3></a></li>
                <li><a href="../../Contact/index.html"><h3>Contact</h3></a></li>
            </ul>
            <div class="mobile-icons">
                <a href=""><div class="icon-container"><a id="account-button-mobile"><img class="icon" src="../../assets/account.png"></div></a></a>
                <a href=""><div class="icon-container"><a id="cart-button-mobile"><img class="icon" src="../../assets/cart.png"></div></a></a>
            </div>
        </div>        
        <div class="icons">
            <a href=""><div class="icon-container"><a id="account-button"><img class="icon" src="../../assets/account.png"></div></a> </a>
            <a href=""><div class="icon-container"><a id="cart-button"><img class="icon" src="../../assets/cart.png"></div></a> </a>
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
                      <a href="#" id="forgot-password">Forgot your password?</a>
                  </li>
                  <li>
                      <button type="submit" form="account-form" id="login">Login</button>
                  </li>
                  <li>
                      <a href="#" id="create-account">New customer? Create a new account</a>
                  </li>
              </ul>    
          </div>
      </div>
      <!-- Sidebars End -->

    <div class="container fade-in blur">
      <div class="left-column">
        <img
          alt="Ballyrina Flat In Black Leather Image 1"
          id="image1"
          height="400"
          src="../../assets/ws11.webp"
          width="600"
        />
        <img
          alt="Ballyrina Flat In Black Leather Image 2"
          id="image2"
          height="400"
          src="../../assets/ws11h.webp"
          width="600"
        />
      </div>
      <div class="right-column">
        <h1>Ballyrina Flat In Black Leather</h1>
        <div class="price">Rp 14.480.000,00 IDR</div>
        <p>
          In soft calfskin, this ballerina flat draws inspiration from Mary Janes to combine elegance and versatility. The leather upper is enriched by a gold-tone metal Emblem buckle, a signifier which subtly references Bally heritage.

          Gold-tone metal Emblem buckle
          Leather lining
          Cemented construction
          Leather sole
          Each pair of Ballyrina flats is luxuriously presented with a specially designed box, satin dust bag, and elegant sticker, all featuring a contemporary gold-tone version of the original 1940s Ballyrina logo.
        </p>
        <div class="config-title">Custom Configuration :</div>
        <div class="config-section">
          <label>SHOE LAST:</label>
          <div class="shoe-last-options">
            <div class="shoe-last-option">
              <img
                alt="Structured"
                height="50"
                src="../../assets/morgan.webp"
                width="50"
                data-description="Structured"
              />
              <div class="description">Structured</div>
            </div>
            <div class="shoe-last-option">
              <img
                alt="Unstructured"
                class="selected"
                height="50"
                src="../../assets/mark.webp"
                width="50"
                data-description="Unstructured"
              />
              <div class="description">Unstructured</div>
            </div>
          </div>
        </div>
        <div id="shoe-last-preview" class="shoe-last-preview"></div>

        <div class="config-section">
          <label>TOE BOX:</label>
          <div class="toe-box-options">
            <div class="toe-box-option">
              <img
                alt="Structured"
                height="50"
                src="../../assets/structure.webp"
                width="50"
                data-description="Structured"
              />
              <div class="description">Structured</div>
            </div>
            <div class="toe-box-option">
              <img
                alt="Unstructured"
                class="selected"
                height="50"
                src="../../assets/unstructure.webp"
                width="50"
                data-description="Unstructured"
              />
              <div class="description">Unstructured</div>
            </div>
          </div>
        </div>
        <div id="toe-box-preview" class="toe-box-preview"></div>
        <div class="config-section">
          <label>SIZE:</label>
          <select>
            <option>Select an option</option>
            <option>40</option>
            <option>41</option>
            <option>42</option>
            <option>43</option>
            <option>44</option>
            <option>45</option>
          </select>
        </div>
        <div class="config-section">
          <label>WIDTH:</label>
          <select>
            <option>Select an option</option>
            <option>D</option>
            <option>E</option>
            <option>EE</option>
          </select>
        </div>
        <div class="config-section">
          <label>UPPER:</label>
          <select name="upper">
            <option>Select an option</option>
            <option>Badalassi Nemesis</option>
            <option>Badalassi Vachetta</option>
            <option>Badalassi Suede</option>
            <option>Badalassi Nubuck</option>
          </select>
          <div class="upper-options"></div> <!-- Container for dynamic options -->
        </div>
        <button id="add-to-cart-button" class="add-to-cart">Add to Cart</button>
      </div>
    </div>
    <!-- Footer Start -->
    <footer class="footer fade-in blur">
      <div class="footer-content">
          <div class="logo">
              <img src="../../assets/brand-logo.png"/>
          </div>
          <div class="footer-menu">
              <a href="../index.html" class="footer-link">Products</a>
              <a href="../indexmale.html" class="footer-link">Male</a>
              <a href="../indexfemale.html" class="footer-link">Female</a>
              <a href="../../Contact/index.html" class="footer-link">Contact</a>
          </div>
          <div class="social">
              <div class="social-icon-container">
                  <a href="" target="_blank" class="social-icon"><img src="../../assets/instagram.png"/></a>    
              </div>
              <div class="social-icon-container">
                  <a href="" target="_blank" class="social-icon"><img src="../../assets/twitter.png"/></a>    
              </div>
              <div class="social-icon-container">
                  <a href="" target="_blank" class="social-icon"><img src="../../assets/whatsapp.png"/></a>    
              </div>
          </div>
      </div>
      <div class="copyright">
          Copyright &copy; 2024 SuShoes Co.
      </div>
  </footer>
    <!-- Footer End -->
    <script src="../scriptProduct.js"></script>
  </body>
</html>