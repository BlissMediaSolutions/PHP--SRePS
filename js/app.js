var app = angular.module("myApp", ["ngRoute"]);
app.config(function ($routeProvider) {
    $routeProvider.when("/", {
        templateUrl: "templates/home.html"
    }).when("/sales", {
        controller: 'SalesController',
        templateUrl: "templates/sales.html"
    }).when("/products", {
        templateUrl: "templates/products.html"
    }).when("/reports", {
        templateUrl: "templates/reports.html"
    }).when("/faq", {
        templateUrl: "templates/faq.html"
    })
});

app.controller('SalesController', function($scope) {
    // CSS Controlls
    $scope.addSelected = true; // Used for setting the side tab.
    
    // JavaScript + Angular
    $scope.productGroups = ['Painkillers', 'Vitamins', 'Topical']; //Add product group strings here
    $scope.gSelected = false; // Initialise whether a group has been selected to false.
    $scope.gSelection; // Var for the group selection.

    $scope.products; // Array to fill with PHP. (using hardcoded data for now.)

    $scope.item; // Object for individual sale items.
    $scope.itemArray = []; // Array of sale items. 

    $scope.readyPage = function () {
        $scope.pageSize = 5;
        $scope.currentPage = 1;
    }

    $scope.populateProducts = function (group) { // Replace with PHP call.
        if (group == "Painkillers") {
            $scope.products = [
                {name:'Panadol', price:'15'},
                {name:'Neurofen', price:'12'},
                {name:'Voltaren', price:'25'}
            ];
        } else if (group == "Vitamins") {
            $scope.products = [
                {name:'Vitamin C', price:'15'},
                {name:'Iron', price:'12'},
                {name:'Zinc', price:'25'}
            ];
        } else if (group == "Topical") {
            $scope.products = [
                {name:'Aloe Vera Spray', price:'15'},
                {name:'Vitamin E Cream', price:'12'},
                {name:'Deep Heat', price:'25'}
            ];
        }
    }

    $scope.groupSelect= function(group){ // used to get selected group.
        $scope.gSelection = group;
        $scope.gSelected = true;

        // PHP Calls to populate product array.
        // Predefined for now.
        $scope.populateProducts($scope.gSelection);
    }

    $scope.createSaleItem = function(product, qty) { // add sale item to array.
        $scope.sale = {name:product.name,qty:qty,cost:parseInt(product.cost)*parseInt(qty)};
        $scope.itemArray.push($scope.sale);
    }

    $scope.maxPage = function () {
        var result = 5;
        return result;
    };

    $scope.nextPage = function () {
        if ($scope.currentPage !== $scope.maxPage()) {
            $scope.currentPage = $scope.currentPage + 1;
        }
    };

    $scope.previousPage = function () {
        if ($scope.currentPage !== 1) {
            $scope.currentPage = $scope.currentPage - 1;
        }
    };

    $scope.readyPage();
});

app.filter('startFrom', function () {
    return function (data, start) {
        return data.slice(start);
    };
});