app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/contact', {
            templateUrl: '/views/contact.html',
            controller: 'ContactController',
            resolve: {
                load: function($ocLazyLoad) {
                    return $ocLazyLoad.load('/js/contactController.js');
                }
            }
        })
        .when('/', {
            templateUrl: '/views/home.html',
            controller: 'HomeController',
            resolve: {
                load: function($ocLazyLoad) {
                    return $ocLazyLoad.load('/js/homeController.js');
                }
            }
        })
        .when('/register', {
            templateUrl: '/views/register.html',
            controller: 'RegisterController',
            resolve: {
                load: function($ocLazyLoad) {
                    return $ocLazyLoad.load('/js/registerController.js');
                }
            }
        })
        .when('/adminLogin', {
            templateUrl: '/views/adminLogin.html',
            controller: 'AdminLoginController',
            resolve: {
                load: function($ocLazyLoad) {
                    return $ocLazyLoad.load('/js/adminLoginController.js');
                }
            }
        })
        // New route to handle dynamic user ID
        .when('/:id', {
            templateUrl: '/views/home.html',
            controller: 'HomeController',
            resolve: {
                load: function($ocLazyLoad) {
                    return $ocLazyLoad.load('/js/homeController.js');
                }
            }
        })
        .otherwise({
            redirectTo: '/'
        });

    // Enable HTML5 mode for clean URLs (no hash)
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
});
