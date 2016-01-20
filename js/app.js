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
	})
	.when('/category/:category', {
		templateUrl: 'templates/categorie.html',
		controller: 'categorieController'
	})
	.when('/search/', {
		templateUrl: 'templates/search.html',
		controller: 'searchController'
	})
});

app.controller('mainController', ['$rootScope', '$scope', function($rootScope, $scope){
	$rootScope.username = "milo";
}]);

app.controller('actorsController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	if (typeof $routeParams.movieId != 'undefined'){
		$http({
			method: 'GET',
			url: '/api/actors/movie/'+$routeParams.movieId
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$scope.actors = response.data;
			}else{
				$scope.error = response.data.error;
			}		
		}, function errorCallback(response) {
	    	// called asynchronously if an error occurs
	    	// or server returns response with an error status.
		});
	} else {
		$http({
			method: 'GET',
			url: '/api/actors/random/5'
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$scope.actors = response.data;
			}else{
				$scope.error = response.data.error;
			}		
		}, function errorCallback(response) {
	   		// called asynchronously if an error occurs
	    	// or server returns response with an error status.
		});
	}
}]);

app.controller('actorController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/actor/'+$routeParams.actorId
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.actor = response.data;
		}else{
			$scope.error = response.data.error;
		}		
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
		if(typeof response.data.error === 'undefined'){
			$scope.movies = response.data;
		}else{
			$scope.error = response.data.error;
		}		
	}, function errorCallback(response) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
		});
	} else {
		$http({
			method: 'GET',
			url: '/api/movies/random/3'
		}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movies = response.data;
		}else{
			$scope.error = response.data.error;
		}		
	}, function errorCallback(response) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
		});
	}
}]);

app.controller('movieController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/movie/'+$routeParams.movieId
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movie = response.data;
		}else{
			$scope.error = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

app.controller('categoriesController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/categories/'
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.categories = response.data;
		}else{
			$scope.error = response.data.error;
		}
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

app.controller('categorieController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){
	$http({
		method: 'GET',
		url: '/api/category/'+$routeParams.category
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movies = response.data;
		}else{
			$scope.error = response.data.error;
		}	
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

app.factory('Search', function () {
    return { data: 'Bla' };
});

app.controller('searchFormContoller', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams, Search){
	$scope.Search = Search;
}]);

app.controller('searchController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams, Search){
	$scope.Search = Search;

	$http({
		method: 'GET',
		url: '/api/movies/'
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movies = response.data;
			console.log(response.data);
		}else{
			$scope.movieError = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
		$http({
		method: 'GET',
		url: '/api/actors/'
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.actors = response.data;
			console.log(response.data);
		}else{
			$scope.actorError = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);