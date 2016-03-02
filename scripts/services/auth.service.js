/*
 * @author Priyank Patel
 * @github https://github.com/PR1YANKPAT3L
 * @desc Contains Auth Serivce Module
 */
(function () {
  define(['angular', 'facebook'], function(angular, facebook) {
    'use strict';

    var app = angular.module('FacebookService', []);

    app.factory('FacebookService', function ($http, $state, $cookies) {
        return {
          watchLoginChange: function () {
            var _self = this;

            FB.Event.subscribe('auth.authResponseChange', function (res) {
              if(res.status === 'connected') {
                $state.go('dashboard');
                $cookies.put('isLoggedIn', true);
              } else {
                $state.go('login');
              }
            });
          },
          getLoginStatus: function() {
            // Get Facebook Login Status
            FB.getLoginStatus(function (response) {
              if(response.status == 'connected') {
                $state.go('dashboard');
                $cookies.put('isLoggedIn', true);
              } else if(response.status == 'not_authorized') {
                $state.go('login');
                $cookies.remove('isLoggedIn');
              } else {
                $state.go('login');
                $cookies.remove('isLoggedIn');
              }
            });
          },
          getUserInfo: function () {
            var _self = this;

            FB.api('/me', function(res) {
              $rootScope.$apply(function () {
                $rootScope.user = _self.user = res;
              });
            });
          }
        };
      });

    return app;
  });
}).call(this);
