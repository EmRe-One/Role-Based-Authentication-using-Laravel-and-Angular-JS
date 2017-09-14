angular.module('app',[
	'ui.router',
	'ngStorage',
	'app.controllers',
	'angular-jwt',
	'app.factories'
	])
.config(['$stateProvider','$locationProvider','jwtInterceptorProvider','$httpProvider','jwtOptionsProvider',function($stateProvider,$locationProvider,jwtInterceptorProvider,$httpProvider,jwtOptionsProvider) {
	$stateProvider.state('homePage',{
		url: '/',
		views: {
			'mainView': {
				templateUrl: 'views/home.html',
				controller: 'HomeController'
			}
		},		
	}).state('dashboard',{
		url: '/dashboard',
		views: {
			'mainView': {
				templateUrl: 'views/dashboard.html',
				controller: 'DashboardController'
			}
		},		
	});
	$httpProvider.interceptors.push('jwtInterceptor');
	$locationProvider.html5Mode(true);
}])
.run(['jwtHelper','$location','auth','$rootScope','$window',function(jwtHelper,$location,auth,$rootScope,$window){
	$rootScope.$watch(
	function() {
		var token = $window.sessionStorage.accessToken;
		if(token){
			return jwtHelper.isTokenExpired($window.sessionStorage.accessToken);
		}else {
			return true;
		}
	},
	function(){
		var token = $window.sessionStorage.accessToken;
		if(token) {
			if(!jwtHelper.isTokenExpired(token)) {
				if(!$rootScope.isAuthenticated) {
					auth.check($window.sessionStorage.accessToken);
					if($location.path()=='/') {
						$location.path('/dashboard');
					}
				}
			}else{
				auth.refreshToken(token,function(success){
					$window.sessionStorage.accessToken = success.data.token;
					$rootScope.isAuthenticated = true;
				},function(error){
	                delete $window.sessionStorage.accessToken;
					$location.path('/');
				});
			}
		}else {
			$location.path('/');
		}
	});
	$rootScope.$watch(
		function() {
			if($location.path()==='/dashboard'){
				return true;
			}else {
				return false;
			}
		},function(){
			if($location.path()==='/dashboard'){
				if(!$rootScope.isAuthenticated) {
					$location.path('/');
				}
			}else {
				$location.path('/');
			}
		});
}]);