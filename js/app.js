'use strict';

var app = angular.module('App', [
    'ngRoute',
    'directives',
    'controllers',
]);

app.config([
    '$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/', {
                controller: 'IndexCtrl',
                templateUrl: 'views/index.html',
            }).
            when('/page/:page', {
                controller: 'PageCtrl',
                templateUrl: function(params){ return 'pages/' + params.page + '.html'; }
            }).
            otherwise({
                redirectTo: '/'
            });
    }
]);
