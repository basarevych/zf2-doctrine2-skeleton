'use strict';

var directives = angular.module('directives', []);

directives.directive('snippet',
    [ '$timeout', '$interpolate', 
    function($timeout, $interpolate) {
        return {
            scope: {
                class: '@',
            },
            restrict: 'E',
            template: '<pre><code ng-transclude></code></pre>',
            replace: true,
            transclude: true,
            link: function(scope, elm, attrs) {
                var tmp =  $interpolate(elm.find('code').text())(scope);
                $timeout(function() {                
                    elm.find('code').html(
                        angular.isDefined(scope.class)
                            ? hljs.highlight(scope.class, tmp).value
                            : hljs.highlightAuto(tmp).value
                    );
                });
            }
        };
    }]
);
