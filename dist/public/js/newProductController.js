app.controller('NewProductController', function($scope, $timeout, $routeParams, $http) {
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

    // Initialize the product
    $scope.product = {
        image1: null,
        image2: null,
        name: '',
        price: '',
        description: '',
        type: '',
        gender: '',
        stock: ''
    };

    // Handle image preview for both images
    $scope.updateImagePreview = function(event, imageIndex) {
        var reader = new FileReader();
        reader.onload = function(e) {
        if (imageIndex === 1) {
            $scope.product.image1 = e.target.result;
        } else if (imageIndex === 2) {
            $scope.product.image2 = e.target.result;
        }
        $scope.$apply(); // Apply the changes to the scope after the file is loaded
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    // Handle form submission
    $scope.submitForm = function() {
        if ($scope.addProductForm.$valid) {
            // Form data is valid, let's prepare the data for submission
            var formData = new FormData();
            formData.append('name', $scope.product.name);
            formData.append('price', $scope.product.price);
            formData.append('description', $scope.product.description);
            formData.append('type', $scope.product.type);
            formData.append('gender', $scope.product.gender);
            formData.append('stock', $scope.product.stock);
            
            // Append the image files to form data (if selected)
            if ($scope.product.image1) {
                formData.append('img1', dataURLtoFile($scope.product.image1, 'img1.jpg'));
            }
            if ($scope.product.image2) {
                formData.append('img2', dataURLtoFile($scope.product.image2, 'img2.jpg'));
            }

            // Send the form data to the server
            $http.post('/api/product', formData, {
                headers: { 'Content-Type': undefined }
            }).then(function(response) {
                // Handle success
                alert('Product added successfully!');
                // Reset form
                $scope.product = {
                    image1: null,
                    image2: null,
                    name: '',
                    price: '',
                    description: '',
                    stock: ''
                };
                $scope.addProductForm.$setPristine();
            }).catch(function(error) {
                // Handle error
                alert('Error adding product!');
                console.error(error);
            });
        } else {
        alert('Please fill out all required fields.');
        }
    };

    // Utility function to convert dataURL to for image
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
        var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
        u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type: mime});
    }

    $scope.adminId = $routeParams.id;
});
