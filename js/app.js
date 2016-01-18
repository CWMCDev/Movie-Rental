var app = angular.module('movieRentalApp',['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/actors/', {
		templateUrl: 'templates/actors.html',
		controller: 'actorsController'
	})
	.when('/actor/:actorId', {
		templateUrl: 'templates/actor.html',
		controller: 'actorController'
	})
	.when('/movies', {
		templateUrl: 'templates/movies.html',
		controller: 'moviesController'
	})
	.when('/movie/:movieId', {
		templateUrl: 'templates/movie.html',
		controller: 'movieController'
	});
});

app.controller('mainController', ['$rootScope', '$scope', function($rootScope, $scope){
	$rootScope.username = "milo";
}]);

app.controller('actorsController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/actors/random/5'
	}).then(function successCallback(response) {
		$scope.actors = response.data;
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

app.controller('actorController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/actor/'+$routeParams.actorId
	}).then(function successCallback(response) {
		$scope.actor = response.data;
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

app.controller('moviesController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	if (typeof $routeParams.actorId != 'undefined'){
		$http({
			method: 'GET',
			url: '/api/movies/actor/'+$routeParams.actorId
		}).then(function successCallback(response) {
			console.log(response)
			$scope.movies = response.data;
		}, function errorCallback(response) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
		});
	} else {
		$http({
			method: 'GET',
			url: '/api/movies/random/3'
		}).then(function successCallback(response) {
			$scope.movies = response.data;
		}, function errorCallback(response) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
		});
	}
}]);

app.controller('movieController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){

}]);

app.controller('categoriesController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/categories/'
	}).then(function successCallback(response) {
		$scope.categories = response.data;
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);