var app = angular.module('movieRentalApp',['ngRoute', 'ui.bootstrap']);

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

	.when('/profile/', {
		templateUrl: 'templates/profile.html',
		controller: 'profileController'
	})
});

app.controller('mainController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http){
	$rootScope.currentDate = new Date();
	$http({
			method: 'GET',
			url: '/api/version/'
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$rootScope.version = response.data.git_version;
			}else{
				$scope.error = response.data.error;
			}		
		}, function errorCallback(response) {
	    	// called asynchronously if an error occurs
	    	// or server returns response with an error status.
	    });	
	$rootScope.search = {data: ''};
}]);

//////////////////////
//					//
//		Movies 		//
//					//
//////////////////////

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
	$scope.rating = {
		rate: null,
		isReadonly: false,
		max: 5
	};

	$scope.hoveringOver = function(value) {
		$scope.rating.overStar = value;
	};

	$http({
		method: 'GET',
		url: '/api/movie/'+$routeParams.movieId
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movie = response.data;
			$scope.rating.rate = response.data.rating;
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

app.controller('searchFormController', ['$rootScope', '$scope', '$http', '$routeParams', function($rootScope, $scope, $http, $routeParams){

}]);

app.controller('searchController', ['$rootScope', '$scope', '$http', '$routeParams', function($rootScope, $scope, $http, $routeParams){

	$http({
		method: 'GET',
		url: '/api/movies/'
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			$scope.movies = response.data;
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
		}else{
			$scope.actorError = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
});
}]);

//////////////////////
//					//
//	Customers 		//
//					//
//////////////////////

app.controller('loginController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http){
	$scope.login = function(email){
		$http({
			method: 'GET',
			url: '/api/customer/' + email
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$rootScope.user = response.data[0];
			}else{
				$scope.error = response.data.error;
			}	
		}, function errorCallback(response) {
    		// called asynchronously if an error occurs
    		// or server returns response with an error status.
		});
	}
}]);

app.controller('profileController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http){
	$scope.login = function(email){
		$http({
			method: 'GET',
			url: '/api/customer/' + email
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$rootScope.user = response.data[0];
			}else{
				$scope.error = response.data.error;
			}	
		}, function errorCallback(response) {
    		// called asynchronously if an error occurs
    		// or server returns response with an error status.
		});
	}
}]);

//////////////////////
//					//
//		Misc 		//
//					//
//////////////////////

app.filter('cut', function () {
	return function (value, wordwise, max, tail) {
		if (!value) return '';

		max = parseInt(max, 10);
		if (!max) return value;
		if (value.length <= max) return value;

		value = value.substr(0, max);
		if (wordwise) {
			var lastspace = value.lastIndexOf(' ');
			if (lastspace != -1) {
				value = value.substr(0, lastspace);
			}
		}

		return value + (tail || ' …');
	};
});