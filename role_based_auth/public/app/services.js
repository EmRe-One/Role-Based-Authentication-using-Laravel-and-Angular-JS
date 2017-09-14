var angFactory = angular.module('app.factories',['ngStorage']);
angFactory.factory('auth', ['$http', '$window','$rootScope', function ($http, $window,$rootScope) {
	return {
		signup: function (data, success, error) {
			console.log(data);
			$http({
				method:'POST',
				headers: {
					"Accept":"application/json, text/plain, */*",
					'Content-Type' : 'application/x-www-form-urlencoded'
				},
				url:'http://localhost:8000/api/register',
				data:$.param(data)
			}).then(function(response) {
				success(response);
			},function(response) {
				error(response);
			});
		},
		signin: function (data, success, error) {
			$http({
				method:'POST',
				headers: {
					"Accept":"application/json, text/plain, */*",
					'Content-Type' : 'application/x-www-form-urlencoded'
				},
				url:'http://localhost:8000/api/authenticate',
				data:$.param(data)
			}).then(function(response) {
				success(response);
			},function(response) {
				error(response);
			});
		},
		logout: function (success) {
			delete $window.sessionStorage.accessToken;
		},
		refreshToken: function(token,success,error) {
			$http({
				method:'GET',
				url:'http://localhost:8000/api/refresh/'+token
			}).then(function(response){
				success(response);
			},function(response){
				error(response);
			});
		},
		check: function(){
			$rootScope.isAuthenticated = true;
		},
		getUserPermissionAndRole: function(token,success,error) {
			$http({
				method:'GET',
				url:'http://localhost:8000/api/user/permission/'+token
			}).then(function(response){
				success(response);
			},function(response){
				error(response);
			});
		},
		getUsersList: function(token,success,error) {
			 $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
			$http({
				method:'GET',
				url:'http://localhost:8000/api/users',
			}).then(function(response){
				success(response);
			},function(response){
				error(response);
			});
		}
	};
}
]);