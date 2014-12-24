'use strict';

var controllers = angular.module('controllers', []);

controllers.controller('IndexCtrl',
    ['$scope', '$rootScope',
    function($scope, $rootScope) {
        $rootScope.page = "index";
    }]
);

controllers.controller('PageCtrl',
    ['$scope', '$rootScope', '$routeParams',
    function($scope, $rootScope, $routeParams) {
        $rootScope.page = $routeParams.page;
    }]
);
