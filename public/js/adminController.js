app.controller('AdminController', function($scope, $timeout, $routeParams, $http) {
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

    burgerMenu.addEventListener('click', () => {
        navbarMenu.classList.toggle('active');
        burgerMenu.classList.toggle('active');
    });

    closeButton.addEventListener('click', () => {
        navbarMenu.classList.remove('active');
        burgerMenu.classList.remove('active');
    });

    // Admin Sidebar Navigation
    $('.menu-item').on('click', function () {
        // Highlight selected menu item
        $('.menu-item').removeClass('active');
        $(this).addClass('active');

        // Hide all content containers
        $('.content-container').addClass('hidden');

        // Show the selected content
        const contentId = `#content-${this.id}`;
        $(contentId).removeClass('hidden');
    });

    // Show the Home section by default
    $('#content-home').removeClass('hidden');

    $scope.adminId = $routeParams.id;

     // Function to fetch all contacts
     $scope.getAllContacts = function() {
        $http.get('/api/contacts') // Endpoint to fetch contacts
            .then(function(response) {
                // Success: store the fetched contacts in the $scope.contacts array
                $scope.contacts = response.data.contacts;
            })
            .catch(function(error) {
                // Handle errors
                console.error('Error fetching contacts:', error);
                alert('Failed to fetch contacts. Please try again later.');
            });
    };

    // Call the function when the controller is initialized
    $scope.getAllContacts();
});
