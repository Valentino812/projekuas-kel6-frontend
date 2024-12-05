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

    // Fetching transactions for a specific user from the server
    $scope.getUserTransactions = function(userId) {
        $http.get('/api/user-transactions/' + userId)
            .then(function(response) {
                $scope.transactions = response.data;
                console.log('User Transactions:', $scope.transactions); // Log the transactions to the console
            })
            .catch(function(error) {
                console.error('Error fetching user transactions:', error);
            });
    };

    // Call getUserTransactions with the userId from the URL
    $scope.getUserTransactions($routeParams.id);

    // CRUD METHODS END
});
