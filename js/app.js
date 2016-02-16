var app = angular.module('movieRentalApp',['ngRoute', 'ngStorage', 'ui.bootstrap', 'chart.js']);


app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when('/', {
		templateUrl: 'templates/index.html',
		controller: 'indexController'
	})
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

	.when('/admin/', {
		templateUrl: 'templates/admin.html',
		controller: 'adminController'
	})
});

app.controller('mainController', ['$rootScope', '$scope', '$localStorage', '$http', function($rootScope, $scope, $localStorage, $http){
	$rootScope.storage = $localStorage;

	$scope.logout = function(){
		$rootScope.storage.user = null;
	}

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

app.controller('indexController', ['$rootScope', '$scope', '$localStorage', '$http', function($rootScope, $scope, $localStorage, $http){
	$scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales"];
  	$scope.data = [300, 500, 500];
}]);

//////////////////////
//					//
//		Actors 		//
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
			url: '/api/actors/random/12'
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
			$scope.actor.birthdate = new Date($scope.actor.birthdate);
		}else{
			$scope.error = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
}]);

//////////////////////
//					//
//		Movies 		//
//					//
//////////////////////

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

app.controller('movieController', ['$rootScope', '$scope', '$http', '$routeParams', function($rootScope, $scope, $http, $routeParams){
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
	$scope.rentMovie = function(){
		var data = {
			movieID: $scope.movie.movie_id,
			customerID: $rootScope.storage.user.customerID
		}
		$http({
			method: 'POST',
			url: '/api/customer/rentals/rent',
			data: data
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				console.log("Rented with id:" + response.data.id);
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
//	Categories 		//
//					//
//////////////////////

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
			url: '/api/customer/email/' + email
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				$rootScope.storage.user = response.data[0];
			}else{
				$scope.error = response.data.error;
			}	
		}, function errorCallback(response) {
    		// called asynchronously if an error occurs
    		// or server returns response with an error status.
    	});
	}
}]);

app.controller('signupController', ['$rootScope', '$scope', '$http', function($rootScope, $scope, $http){
	$scope.signup = function(signupData){
		signupData.adress.adress = signupData.adress.street + " " + signupData.adress.houseNumber;
		$http({
			method: 'POST',
			url: '/api/customer/',
			data: signupData
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				
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
	$scope.receipt = {rentals:[], step:1};
	$rootScope.$watch('storage.user', function() {
    	$scope.loadRentals();
	});

	$scope.loadRentals = function(){
		if (typeof $rootScope.storage.user != 'undefined' && $rootScope.storage.user != null){
			$http({
				method: 'GET',
				url: '/api/customer/rentals/' + $rootScope.storage.user.customerID
			}).then(function successCallback(response) {
				if(typeof response.data.error === 'undefined'){
					var rentals = [];
					for (index = 0; index < response.data.length; ++index) {
						var rental = response.data[index];
						rental.invoice.dueDate = new Date(rental.invoice.dueDate);
						rental.loanDate = new Date(rental.loanDate);
						rental.isOverdue = $scope.isOverdue(rental.invoice.dueDate, rental.invoice.payed);
						rentals.push(rental);
					};

					$scope.rentals = rentals;
				}else{
					$scope.rentalError = response.data.error;
				}		
			}, function errorCallback(response) {
		    // called asynchronously if an error occurs
		    // or server returns response with an error status.
			});
		}
	}

	$scope.isOverdue = function(date, payed){
		if(payed){
			return false
		}
		return date < $rootScope.currentDate;
	}

	$scope.addToReceipt = function(rental){
		console.log($scope.receipt.rentals.length);
		console.log(rental);
		rental.invoice.paying = true;
		$scope.receipt.rentals.push(rental);
	}

	$scope.removeFromReceipt = function(rental){
		rental.invoice.paying = false;
		var index = $scope.receipt.rentals.indexOf(rental);
		$scope.receipt.rentals.splice(index, 1)
	}

	$scope.calculateReceipt = function(){
		$scope.receipt.total = 0;
		$.each($scope.receipt.rentals,function() {
			$scope.receipt.total += parseFloat(this.invoice.amount);
		});
		$scope.receipt.tax = $scope.receipt.total * 0.21
		$scope.receipt.subTotal = $scope.receipt.total * 0.79
	}

	$scope.pay = function(rentals){
		$http({
			method: 'POST',
			url: '/api/customer/invoice/pay',
			data: $scope.receipt
		}).then(function successCallback(response) {
			if(typeof response.data.error === 'undefined'){
				console.log(response.data);
				for (var i = response.data.length - 1; i >= 0; i--) {
					var rentalID = response.data[i].id
					var rentalPayed = response.data[i].payed

					var object_by_id = $scope.rentals.filter(function(rental){return rental.id == rentalID})[0];
					console.log(object_by_id);
					var index = $scope.rentals.indexOf(object_by_id);
					$scope.rentals[index].invoice.payed = rentalPayed;
					
					for (var i = rentals.length - 1; i >= 0; i--) {
						var rental = rentals[i];
						
						rental.invoice.paying = false;
						var index = $scope.receipt.rentals.indexOf(rental);
						$scope.receipt.rentals.splice(index, 1)
					}
				};
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
//		Admin 		//
//					//
//////////////////////

app.controller('adminController', ['$rootScope', '$scope', '$http', '$routeParams', function($rootScope, $scope, $http, $routeParams){
	$scope.stats = {payed: {}};

	$http({
		method: 'GET',
		url: '/api/stats/payed/'
	}).then(function successCallback(response) {
		if(typeof response.data.error === 'undefined'){
			console.log(response.data);
			$scope.stats.payed.data = response.data;
			$scope.stats.payed.labels = ['Not Payed', 'Payed'];
			$scope.stats.payed.colours = ['#D9534F', '#449D44'];
			$scope.stats.payed.amounts = $scope.stats.payed.data.map(function(stat) {return stat.amount;});
		}else{
			$scope.error = response.data.error;
		}		
	}, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
	});
	
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
