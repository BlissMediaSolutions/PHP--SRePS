var app = angular.module("myApp", ["ngRoute", "ngAnimate", "ngCsv"]);
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
        controller: 'ProductController',
        templateUrl: "./templates/products.html"
    }).when("/reports", {
        controller: 'ReportController',
        templateUrl: "./templates/reports.html"
    }).when("/faq", {
        templateUrl: "./templates/faq.html"
    }).when("/predictions", {
        controller: 'PredictionController',
        templateUrl: "./templates/predictions.html"
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
    $scope.addButtonText = 'Add';
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
        if ($scope.itemEditing != null){
            $scope.sale = $scope.itemEditing;
        }
        else{
            $scope.sale = {
                id : 0
            };
        }
        $scope.sale.productId = product.id;
        $scope.sale.name = product.name;
        $scope.sale.qty = qty;
        $scope.sale.cost = parseFloat(product.price)*parseFloat(qty);
        $scope.sale.productId = product.id;

        if ($scope.itemEditing != null){
            $scope.itemEditing = null;
        }
        else{
            $scope.itemArray.push($scope.sale);
        }
        salesController.updateTotalPrice();
        $scope.addButtonText = 'Add';
        salesController.resetSaleLineForm();
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
        salesController.resetSaleLineForm();
        $scope.itemArray = [];
        $scope.totalPrice = 0.0;
        $location.path('/sales');
    };

    $scope.commitSale = function(){
        var data = {"saleId": $scope.saleId, "items" : $scope.itemArray};
        $http({
            url: './php/AddEditSale.php',
            method: 'POST',
            data: data
        })
        .then(function successCallback(response){
            $scope.cancelSale();
            salesController.resetSaleLineForm();
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
        });
    };

    //Remove an item from our Items array, and update the total price
    $scope.deleteItem = function(itemIndex){
        if ($scope.itemEditing == $scope.itemArray[itemIndex]){
            $scope.itemEditing = null; //in case we're editing the item being deleted
            $scope.addButtonText = 'Add';
        }
        $scope.itemArray.splice(itemIndex, 1);
        salesController.updateTotalPrice();
    }

    //Allow a particular saleline to be edited
    $scope.editItem = function(itemIndex){
        $scope.itemEditing = $scope.itemArray[itemIndex];
        $scope.addButtonText = 'Update';

        //Only have the product ID, but to display correctly need
        //all products in the group + the group name
        $http({
            url: './php/GetProductsInGroupFromProductId.php',
            method: 'GET',
            params: { 'ProductId' : $scope.itemEditing.productId}
        })
        .then(function successCallback(response){
            //Identify product group
            for (var i = 0; i < $scope.productGroups.length; i++){
                if ($scope.productGroups[i].Id == response.data.productGroupId){
                    $scope.productGroup = $scope.productGroups[i];
                    break;
                }
            }

            //Populate products
            $scope.products = response.data.products;
            //Select correct product
            for (var i = 0; i < $scope.products.length; i++){
                if ($scope.products[i].id == $scope.itemEditing.productId){
                    $scope.product = $scope.products[i];
                    break;
                }
            }
            $scope.gSelected = true;
            $scope.qty = $scope.itemEditing.qty;
        });
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

    this.resetSaleLineForm = function(){
        $scope.productGroup = null;
        $scope.product = null;
        $scope.products = null;
        $scope.gSelected = false;
        $scope.qty = null;
    };

    $scope.readyPage();
});

function isEmpty(value) {
  return angular.isUndefined(value) || value === '' || value === null || value !== value;
}

//The default ng-max validation attribute with Angular doesn't allow you to bind to 
//something in your Controller, this should fix it.
//From http://jsfiddle.net/g/s5gKC/ accessed 4/10/2016
app.directive('ngMax', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function(scope, elem, attr, ctrl) {
            scope.$watch(attr.ngMax, function(){
                ctrl.$setViewValue(ctrl.$viewValue);
            });
            var maxValidator = function(value) {
              var max = scope.$eval(attr.ngMax) || Infinity;
              if (!isEmpty(value) && value > max) {
                ctrl.$setValidity('ngMax', false);
                return undefined;
              } else {
                ctrl.$setValidity('ngMax', true);
                return value;
              }
            };

            ctrl.$parsers.push(maxValidator);
            ctrl.$formatters.push(maxValidator);
        }
    };
});

app.filter('startFrom', function () {
    return function (data, start) {
        return data.slice(start);
    };
});

app.controller('ReportController', function($scope, $http) {
    WEEKLY = "Weekly";
    MONTHLY = "Monthly";
    ALL = "All"
    // Show select screen.
    $scope.selectHidden = false;
    // Set report shown to 'null'
    $scope.reportToShow = 0

    $scope.hideTable = true;

    // Set up sales array for population.
    $scope.salesArray = [];

    // Date for naming CSV reports.
    $scope.startDate = {value: new Date()};

    $scope.populateSalesArray = function (reportType) {
        var selectedDate = $scope.startDate.value == null ? null : $scope.startDate.value.toISOString();
        $http({
            url: './php/DisplaySales.php',
            method: 'GET',
            params: {'ReportType' : reportType,
                     'StartDate'  : selectedDate}
        })
        .then(function successCallback(response){
            $scope.salesArray = response.data;
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
            $scope.itemArray = [];
        });
    }

    //Remove a sale both from the database and the display
    $scope.deleteSale = function(saleId){
        $http({
            url: './php/DeleteSale.php',
            method: 'GET',
            params: {'SaleId' : saleId}
        })
        .then(function successCallback(response){
            //Item has been deleted from the database. Stop displaying it.
            for (var i = 0; i < $scope.salesArray.length; i++){
                if ($scope.salesArray[i].ID == saleId){
                    $scope.salesArray.splice(i, 1);
                    break;
                }
            }
        }, function errorCallback(response){
            //Oops! Figure out what to do here...
        });
    }

    $scope.destroySalesArray = function () {
        $scope.salesArray = [];
    }

    $scope.returnToSelect = function () {
        // Show select screen.
        $scope.selectHidden = false;
        // Set report shown to 'null'
        $scope.reportToShow = 0;
        $scope.hideTable = true;
        $scope.destroySalesArray();
    }

    $scope.hideSelect = function() {
        $scope.selectHidden = true;
    }

    $scope.showWeekly = function() {
        $scope.hideSelect();
        //$scope.populateSalesArray(WEEKLY);
        $scope.reportToShow = 1;
    }

    $scope.showMonthly = function() {
        $scope.hideSelect();
        //$scope.populateSalesArray(MONTHLY);
        $scope.reportToShow = 2;
    }

    $scope.showAll = function() {
        $scope.hideSelect();
        $scope.populateSalesArray(ALL);
        $scope.reportToShow = 3;
    }

    $scope.getWeeklySales = function(){
        $scope.populateSalesArray(WEEKLY);
        $scope.hideTable = false;
    }

    $scope.getMonthlySales = function(){
        $scope.populateSalesArray(MONTHLY);
        $scope.hideTable = false;
    }
});

app.filter('quantityToOrder', function(){
    return function(product){
        var rec = product.RecommendedStockLevel - product.QuantityOnHand;
        if (rec < 0)
            return 0;
        return rec;
    }
});

app.filter('lastFourWeeks', function(){
    var padRight5 = function(s){
        if (s.length >= 5)
            return s;
        for (var i = s.length - 1; i < 5; i++){
            s += "&nbsp;";
        }
        return s;
    };

    return function(product){
        var result = padRight5(product.FourWeeksAgo) + 
                     padRight5(product.ThreeWeeksAgo) +
                     padRight5(product.TwoWeeksAgo) + 
                     product.LastWeek;
        return result;


        // var fourWeeksAgoSales = ("     " + product.FourWeeksAgo).slice(-5);
        // var threeWeeksAgoSales = ("     " + product.ThreeWeeksAgo).slice(-5);
        // var twoWeeksAgoSales = ("     " + product.TwoWeeksAgo).slice(-5);
        // var lastWeekSales = ("     " + product.LastWeek).slice(-5);

        // var result = fourWeeksAgoSales + threeWeeksAgoSales + twoWeeksAgoSales + lastWeekSales;
        // return result;
    }
});

app.controller('PredictionController', function($scope, $http) {
    // PHP call to fill 'product' array.
    // Each product object containing information about the product, particularly the average quanitity sold + quantity on hand.
    // Using the two values, provide 'amount to order.'

    // Bool for table hide.
    $scope.predictionHide = true;

    // Create Array.
    $scope.productArray = [];

    // Will impliement the PHP to retrieve all of the products & their data.
    // Using the 'addProduct' function to add each product to the array.
    // The array is updated and 'unhidden' on this function call.
    $scope.getPredictions = function () {
        $scope.predictionHide = false;
        // PHP GET HERE
        $http({
            url: './php/Order.php',
            method: 'GET'
        })
        .then(function successCallback(response){
           $scope.productArray = response.data;
        });
    };
});

app.controller('ProductController', function($scope, $http) {
    // Hard coded pGroup data
    $scope.productGroups = [
        {'Id':1, 'Name':'Painkillers'},
        {'Id':2, 'Name':'Prescription drugs'},
        {'Id':3, 'Name':'Vitamins'},
        {'Id':4, 'Name':'Fragrances'},
        {'Id':5, 'Name':'Weight loss'},
        {'Id':6, 'Name':'Dental care'}];

    //What to display
    $scope.showAllProducts = true;
    $scope.addEditTab = false;

    var productController = this;

    $scope.addButton = function() {
        $scope.addEditTab = true;
        $scope.showAllProducts = false;

        $scope.product = {
            id: 0,
            name: null,
            productGroupId: null,
            price: 0.00,
            quantityOnHand: 0
        };

        $scope.addEditLabel = "Add";
    }

    $scope.editProduct = function(product) {
        $scope.addEditTab = true;
        $scope.showAllProducts = false;

        $scope.product = {
            id: product.id,
            name: product.name,
            productGroupId: product.productGroupId,
            price: Number(product.price),
            quantityOnHand: parseInt(product.quantityOnHand)
        };

        //Select correct product group
        for (var i = 0; i < $scope.productGroups.length; i++){
            if ($scope.productGroups[i].Id == product.productGroupId){
                $scope.productGroup = $scope.productGroups[i];
                break;
            }
        }

        $scope.addEditLabel = "Update";
    }

    $scope.return = function() {
        // Tab view reset
        $scope.addEditTab = false;
        $scope.showAllProducts = true;
        productController.refreshProducts();
    }

    //After the user has added/edited a product, call the backend to commit this to the database
    $scope.addEditProduct = function() {
        //Populate the product group Id
        $scope.product.productGroupId = $scope.productGroup.Id;
        $http({
            url: './php/AddEditProduct.php',
            method: 'GET',
            params: {
                'ProductId' : $scope.product.id,
                'ProductGroupId' : $scope.product.productGroupId,
                'Name' : $scope.product.name,
                'Price' : $scope.product.price,
                'QuantityOnHand' : $scope.product.quantityOnHand
            }
        })
        .then(function successCallback(response){
            $scope.return();
        });
    };

    //Delete a specified product if the user confirms this is what they want to do
    $scope.deleteProduct = function(productId){
        bootbox.confirm("Delete this product?", function(result){
            if (!result) return;
            $http({
                url: './php/DeleteProduct.php',
                method: 'GET',
                params: {
                    'ProductId' : productId
                }
            })
            .then(function successCallback(response){
                //Product has been deleted from the database. Stop displaying it.
                for (var i = 0; i < $scope.products.length; i++){
                    if ($scope.products[i].id == productId){
                        $scope.products.splice(i, 1);
                        break;
                    }
                }
            });
        })
    };

    //Refresh the list of products
    this.refreshProducts = function(){
        $http({
            url: './php/GetProducts.php',
            method: 'GET'
        })
        .then(function successCallback(response){
            $scope.products = response.data;
        }, function errorCallback(response){
            //Ooops! figure out what to do here...
            $scope.products = [];
        });
    };

    //Show products straight away
    this.refreshProducts();
});
