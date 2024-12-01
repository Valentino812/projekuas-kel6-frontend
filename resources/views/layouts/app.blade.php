<!DOCTYPE html>
<html lang="en" ng-app="authApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuShoes Page</title>
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>
    <!-- JQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ocLazyLoad to use controllers dynamicly -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/oclazyload/1.1.0/ocLazyLoad.min.js"></script>

    <!-- Main Angular Js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/route.js') }}"></script>
    <script src="{{ asset('js/services.js') }}"></script>

    <!-- Controllers for each page -->
    <script src="{{ asset('js/homeController.js') }}"></script>
    <script src="{{ asset('js/contactController.js') }}"></script>
    <script src="{{ asset('js/registerController.js') }}"></script>
    <script src="{{ asset('js/adminLoginController.js') }}"></script>
    <script src="{{ asset('js/productsController.js') }}"></script>
    <script src="{{ asset('js/adminController.js') }}"></script>
    <script src="{{ asset('js/settingsController.js') }}"></script>
    <script src="{{ asset('js/newProductController.js') }}"></script>

    <!-- Icon for title bar -->
    <link rel="icon" href=
        "{{ asset('img/brand-logo.png') }}"
    type="image/png" />
</head>
<body>
    <!-- Tempat menampilkan halaman -->
    <div ng-view></div>
</body>
</html>
