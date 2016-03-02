/*
 * @author Priyank Patel
 * @github https://github.com/PR1YANKPAT3L
 * @desc Contains RequireJS configuration Content
 */
(function () {
	require.config({
		paths: {
			angular: 'vendor/angular.min',
			'angularRouter': 'vendor/angular-ui-router.min',
			'angularMaterial': 'vendor/angular-material.min',
			'angularAnimate': 'vendor/angular-animate.min',
			'angularAria': 'vendor/angular-aria.min',
			'angular-cache': 'vendor/angular-cache.min',
      'facebook': 'https://connect.facebook.net/en_US/all',
      'AuthService': 'services/auth.service'
		},
		shim: {
			angular: {
				exports: 'angular'
			},
			angularRouter: ['angular'],
      angularAnimate: {
        deps: ['angular']
      },
      angularAria: {
        deps: ['angular']
      },
			angularMaterial: {
				deps: ['angular', 'angularAria', 'angularAnimate']
			},
      'facebook': {
        exports: 'FB'
      }
		}
	});

	require(['angular', 'app.min'], function(angular, app) {
		'use strict';

		angular.bootstrap(document, [app.name]);
	});
}).call(this);
