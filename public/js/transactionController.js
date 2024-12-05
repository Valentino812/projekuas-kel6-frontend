app.controller('TransactionController', function($scope, $http, $routeParams, $timeout) {
    // VIEWS START
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

    // VIEWS END


    // CRUD METHODS START

    // Data needed for register
    $scope.user = {
        first_name: '',
        last_name: '',
        email: '',
        password: ''
    };

    // Error and sucess message
    $scope.errorMessage = '';
    $scope.successMessage = '';

    // Function to register new account
    $scope.register = function() {
        // Sending data to API with POST request
        $http.post('/api/register', $scope.user)
            .then(function(response) {
                // If successful
                $scope.successMessage = response.data.message;
                $scope.errorMessage = '';
                $scope.user = {}; 
            })
            .catch(function(error) {
                // if failed
                if (error.data && error.data.message) {
                    $scope.errorMessage = error.data.message;
                } else {
                    $scope.errorMessage = 'An error occurred. Please try again.';
                }
                $scope.successMessage = '';
            });
    };

    // Fetching cart data from the server
    $scope.getTransactions = function() {
        const userId = $routeParams.userId; // Get user ID from route parameters
        $http.get(`/api/transactions` + userId)
            .then(function(response) {
                $scope.transactions = response.data;
                console.log('Transactions:', $scope.transactions); // Log the transactions to the console
            })
            .catch(function(error) {
                console.error('Error fetching carts:', error);
            });
    };

    // Call fetchCarts when the controller is initialized
    $scope.getTransactions();

    // CRUD METHODS END
});
