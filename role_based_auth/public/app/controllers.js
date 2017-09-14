angular.module('app.controllers',[
		'app.directives',
		'app.factories',
		'ngStorage'
]).controller('HomeController', ['$scope','$http','$window','$rootScope','auth',function($scope,$http,$window,$rootScope,auth) {
	function successAuth(res) {
		console.log(res);
	  $window.sessionStorage.accessToken = res.data.token;
	  $rootScope.isAuthenticated = true;
	  window.location = "/dashboard";
	}
	$scope.submit = function() {
		var data = {email:$scope.email, password:$scope.password};
		auth.signin(data,successAuth,function(error){
			console.log(error);
		});
	}

	$scope.register = function() {
		var data = {name:$scope.name, email:$scope.registerEmail, password:$scope.registerPassword};
		auth.signup(data,successAuth,function(error){
			console.log(error);
		});
	}

}]).controller('DashboardController', ['$scope','$http','$window','auth','$rootScope',function($scope,$http,$window,auth,$rootScope) {
	$scope.logout = function() {
		$rootScope.isAuthenticated = false;
		auth.logout(function () {
		   window.location = "/";
		});		
	}
	var token = $window.sessionStorage.accessToken;
	auth.getUserPermissionAndRole(token,function(success){
		$scope.userType = success.data.role;
		$scope.readPermission =  success.data.permissions['R'];
		$scope.writePemission =  success.data.permissions['W'];
		$scope.executePermission =  success.data.permissions['X'];
		$scope.createUser =  success.data.permissions['create-users'];
	},function(error){
		$scope.userType = 'NA';
		$scope.readPermission =  'NA';
		$scope.writePemission =  'NA';
		$scope.executePermission =  'NA';
		$scope.createUser =  'NA';
	});
	auth.getUsersList(token,function(success){
		$scope.users = success.data.users;
	},function(error){
		console.log(error);
	});
	$scope.message = 'Dasboard Page';
}]);