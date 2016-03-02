/*
 * @author Priyank Patel
 * @github https://github.com/PR1YANKPAT3L
 * @desc Contains Auth Serivce Module
 */
(function () {
  define(['angular', 'facebook'], function(angular, facebook) {
    'use strict';

    var app = angular.module('FacebookService', []);

    app.factory('FacebookService', function ($http, $state) {
        return {
          watchLoginChange: function () {
            var _self = this;

            FB.Event.subscribe('auth.authResponseChange', function (res) {
              if(res.status === 'connected') {
                $state.go('dashboard');
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
              } else if(response.status == 'not_authorized') {
                $state.go('login');
              } else {
                $state.go('login');
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
