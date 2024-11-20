// JavaScript untuk interaksi jika diperlukan

$(document).ready(function()  {

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

    // Menangani toggle burger menu untuk responsivitas (opsional)
    const burgerMenu = document.getElementById('burger-menu');
    const navbarMenu = document.querySelector('.navbar-menu');
    const closeButton = document.getElementById('close-button');

    burgerMenu.addEventListener('click', () => {
        navbarMenu.classList.toggle('active');
        closeButton.style.display = 'block';
    });

    closeButton.addEventListener('click', () => {
        navbarMenu.classList.remove('active');
        closeButton.style.display = 'none';
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

    // Handle "Add to Cart" button click
    const addToCartButton = document.getElementById('add-to-cart-button');
    addToCartButton.addEventListener('click', () => {
        alert('Item added to cart!');
    });

     // Sidebars Start
     const cartButton = document.getElementById('cart-button');
     const cartButtonMobile = document.getElementById('cart-button-mobile');
     const accountButton = document.getElementById('account-button');
     const accountButtonMobile = document.getElementById('account-button-mobile');
     const sidebarCart = document.querySelector('.sidebar-cart');
     const sidebarAccount = document.querySelector('.sidebar-account');
     const closeCartButton = document.getElementById('close-cart');
     const closeAccountButton = document.getElementById('close-account');
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
     // Sidebars End

});