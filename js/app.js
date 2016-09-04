var app = angular.module("myApp", ["ngRoute"]);
app.config(function ($routeProvider) {
    $routeProvider.when("/", {
        templateUrl: "./templates/home.html"
    }).when("/sales", {
        controller: 'SalesController',
        templateUrl: "./templates/sales.html"
    }).when("/sales/:saleId", {
        controller: 'SalesController',
        templateUrl: "./templates/sales.html"
    }).when("/products", {
        templateUrl: "./templates/products.html"
    }).when("/reports", {
        templateUrl: "./templates/reports.html"
    }).when("/faq", {
        templateUrl: "./templates/faq.html"
    })
});

app.controller('SalesController', function($scope, $http, $routeParams, $location) {
    // CSS Controlls
    $scope.addSelected = true; // Used for setting the side tab.

    // JavaScript + Angular
    //Product groups hardcoded for now, later replace with call to back-end
    $scope.productGroups = [
        {'Id':1, 'Name':'Painkillers'},
        {'Id':2, 'Name':'Prescription drugs'},
        {'Id':3, 'Name':'Vitamins'},
        {'Id':4, 'Name':'Fragrances'},
        {'Id':5, 'Name':'Weight loss'},
        {'Id':6, 'Name':'Dental care'}];
    $scope.gSelected = false; // Initialise whether a group has been selected to false.
    $scope.gSelection; // Var for the group selection.

    $scope.products; // Array to fill with PHP. (using hardcoded data for now.)

    $scope.item; // Object for individual sale items.
    $scope.itemArray = []; // Array of sale items.
    $scope.totalPrice = 0.0;
    $scope.saleId = 0;
    var salesController = this;

    $scope.readyPage = function () {
        $scope.pageSize = 5;
        $scope.currentPage = 1;
        if ($routeParams.saleId != null){
            $scope.saleId = $routeParams.saleId;
            $scope.addSelected = false;
            $scope.editSelected = true;
            salesController.loadSale();
        }
    }

    $scope.populateProducts = function ($groupId) {
        $http({
            url: './php/GetProductGroup.php',
            method: 'GET',
            params: {'ProductGroupId' : $groupId}
        })
        .then(function successCallback(response){
            $scope.products = response.data;
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
            $scope.products = null;
        });
    }

    $scope.groupSelect= function(group){ // used to get selected group.
        $scope.gSelection = group;
        $scope.gSelected = true;

        // PHP Calls to populate product array.
        // Predefined for now.
        $scope.populateProducts($scope.gSelection);
    }

    $scope.createSaleItem = function(product, qty) { // add sale item to array.
        $scope.sale = {
            id:0, //signals this is a new item
            productId:product.id,
            name:product.name,
            qty:qty,
            cost:parseFloat(product.price)*parseFloat(qty)
        };
        $scope.itemArray.push($scope.sale);
        salesController.updateTotalPrice();
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

    $scope.cancelSale = function() {
        $scope.itemArray = [];
        $scope.totalPrice = 0.0;
    };

    $scope.commitSale = function(){
        var data = {"saleId": $scope.saleId, "items" : $scope.itemArray};
        $http({
            url: './php/AddEditSale.php',
            method: 'POST',
            data: data
        })
        .then(function successCallback(response){
            $scope.itemArray = [];
            $scope.totalPrice = 0.0;
            $location.path('/sales');
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
        });
    };

    //Remove an item from our Items array, and update the total price
    $scope.deleteItem = function(itemIndex){
        $scope.itemArray.splice(itemIndex, 1);
        salesController.updateTotalPrice();
    }

    //Calculate the total price based on the items
    this.updateTotalPrice = function() {
        var price = 0;
        for (var i = 0; i < $scope.itemArray.length; i++){
            price += $scope.itemArray[i].cost;
        }
        $scope.totalPrice = price;
    };

    //Load details of an existing sale from the back-end
    this.loadSale = function(){
        $http({
            url: './php/GetSale.php',
            method: 'GET',
            params: {'SaleId' : $scope.saleId}
        })
        .then(function successCallback(response){
            $scope.itemArray = response.data;
            salesController.updateTotalPrice();
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
            $scope.itemArray = [];
        });
    };

    $scope.readyPage();
});

app.filter('startFrom', function () {
    return function (data, start) {
        return data.slice(start);
    };
});
