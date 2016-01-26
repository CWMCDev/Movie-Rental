<?php
require __DIR__ . '/../classes/database/databasecomm.class.php';
require __DIR__ . '/../classes/objectEditor.php';
require __DIR__ . '/../classes/helper.php';

// Routes
function createResponse($data=array()) {
	if(isset($_GET['format']) && $_GET['format'] == 'xml') {
		$array = array('data'=>$data);
		$xml = new SimpleXMLElement('<response/>');
		array_walk_recursive($array, array ($xml, 'addChild'));
		echo $xml->asXML();
	} else {
		if(isset($_GET['callback'])) {
			echo $_GET['callback'].'(';
		}	
		echo json_encode($data, JSON_PRETTY_PRINT);
		if(isset($_GET['callback'])) {
			echo ')';
}
}
}

//////////////////////
//					//
//		ACTOR 		//
//					//
//////////////////////

$app->get('/actor/{actorId}', function ($request, $response, $args) {
	if($actorData = getActor($args['actorId'])){
		$actor = editActor(mysqli_fetch_array($actorData));
		createResponse($actor);
	} else {
		createResponse(array('error' => 'Could not load actor.'));
	}
});

$app->get('/actor/search/{actorName}', function ($request, $response, $args) {
	if($actorData = getActorNameLike($args['actorName'])){
		$actors = array();

		while($actor = mysqli_fetch_array($actorData)){
			array_push($actors, editActor($actor));
		}

		createResponse($actors);
	} else {
		createResponse(array('error' => 'No actors found for the '.$args['actorName'].' search term.'));
	}
});

$app->get('/actors/random/{amount}', function ($request, $response, $args) {
	if($actorData = getRandomActors($args['amount'])){
		$actors = array();

		while($actor = mysqli_fetch_array($actorData)){
			array_push($actors, editActor($actor));
		}   

		createResponse($actors);
	} else {
		createResponse(array('error' => 'No actors found.'));
	}
});

$app->get('/actors/', function ($request, $response, $args) {
	if($actorData = getAllActors()){
		$actors = array();

		while($actor = mysqli_fetch_array($actorData)){
			array_push($actors, editActor($actor));
		}

		createResponse($actors);
	} else {
		createResponse(array('error' => 'No actors found.'));
	}
});

$app->get('/actors/movie/{movieId}', function ($request, $response, $args) {
	if($actorData = getActorsfromMovie($args['movieId'])){
		$actors = array();

		while($actor = mysqli_fetch_array($actorData)){
			array_push($actors, editActor($actor));
		}

		createResponse($actors);
	} else {
		createResponse(array('error' => 'No actors found for this movie.'));
	}
});

//////////////////////
//					//
//		MOVIES 		//
//					//
//////////////////////

$app->get('/movie/{movieId}', function ($request, $response, $args) {
	if($movieData = getMovie($args['movieId'])){
		$movie = mysqli_fetch_array($movieData);
		createResponse($movie);
	} else {
		createResponse(array('error' => 'Could not load movie.'));
	}
});

$app->get('/movie/search/{movieName}', function ($request, $response, $args) {
	if($movieData = getmovieNameLike($args['movieName'])){
		$movies = array();

		while($movie = mysqli_fetch_array($movieData)){
			array_push($movies, $movie);
		}

		createResponse($movies);
	} else {
		createResponse(array('error' => 'No movies found for the '.$args['movieName'].' search term.'));
	}
});

$app->get('/movies/random/{amount}', function ($request, $response, $args) {
	if($movieData = getRandommovies($args['amount'])){
		$movies = array();

		while($movie = mysqli_fetch_array($movieData)){
			array_push($movies, $movie);
		}   

		createResponse($movies);
	} else {
		createResponse(array('error' => 'No movies found.'));
	}
});

$app->get('/movies/', function ($request, $response, $args) {
	if($movieData = getAllmovies()){
		$movies = array();

		while($movie = mysqli_fetch_array($movieData)){
			array_push($movies, $movie);
		}

		createResponse($movies);
	} else {
		createResponse(array('error' => 'No movies found.'));
	}
});

$app->get('/movies/actor/{actorId}', function ($request, $response, $args) {
	if($movieData = getMoviesFromActor($args['actorId'])){
		$movies = array();

		while($movie = mysqli_fetch_array($movieData)){
			array_push($movies, $movie);
		}

		createResponse($movies);
	} else {
		createResponse(array('error' => 'No movies found for this actor.'));
	}
});

//////////////////////
//					//
//	CATEGORIES 		//
//					//
//////////////////////
$app->get('/category/{category}', function ($request, $response, $args) {
	if($categoryData = getMoviesFromCategory($args['category'])){
		$movies = array();

		while($movie = mysqli_fetch_array($categoryData)){
			array_push($movies, $movie);
		}
		createResponse($movies);
	} else {
		createResponse(array('error' => 'No movies found for the '.$args['category'].' category.'));
	}
});

$app->get('/categories/', function ($request, $response, $args) {
	$categories = getAllCategories();

	createResponse($categories);
});

//////////////////////
//					//
//	Customers 		//
//					//
//////////////////////

$app->get('/customer/email/{email}', function ($request, $response, $args) {
	if($customerData = getUsersFromEmail($args['email'])){
		$users = array();

		while($user = mysqli_fetch_array($customerData)){
			array_push($users, editCustomer($user));
		}
		createResponse($users);
	} else {
		createResponse(array('error' => 'No users found with that email adress.'));
	}
});

$app->get('/customer/{customer_id}', function ($request, $response, $args) {
	if($customerData = getUserFromID($args['customer_id'])){
		$user = mysqli_fetch_array($customerData);

		createResponse(editCustomer($user));
	} else {
		createResponse(array('error' => 'No user found with that id.'));
	}
});

$app->post('/customer/', function ($request, $response) {
	$args = $request->getParsedBody();
	$errors = array();
	if(empty($args['firstName'])){
		array_push($errors, 'No First Name set!');
	}
	if(empty($args['lastName'])){
		array_push($errors, 'No Last Name set!');
	}
	if(empty($args['email'])){
		array_push($errors, 'No email set!');
	}else if(!isValidEmail($args['email'])){
		array_push($errors, 'Email Invalid!');
	}
	if(empty($args['phoneNumber'])){
		array_push($errors, 'No phone number set!');
	}
	if(empty($args['adress']['adress'])){
		array_push($errors, 'No adress set!');
	}
	if(empty($args['adress']['postalCodeNumbers']) || empty($args['adress']['postalCodeLetters'])){
		array_push($errors, 'No postal code set!');
	}
	if(empty($args['adress']['city'])){
		array_push($errors, 'No city set!');
	}
	if(empty($args['adress']['country'])){
		array_push($errors, 'No country set!');
	}

	if(!empty($errors)){
		createResponse($errors);
	} else {
		createResponse(array('id' => createCustomer($args)));
	}
});

//////////////////////
//					//
//	Rentals 		//
//					//
//////////////////////

$app->get('/customer/rentals/{id}', function ($request, $response, $args) {
	if($rentalData = getrentalsFromUser($args['id'])){
		$rentals = array();

		while($rental = mysqli_fetch_array($rentalData)){
			array_push($rentals, editRental($rental));
		}
		createResponse($rentals);
	} else {
		createResponse(array('error' => 'No rentals found for that user.'));
	}
});

$app->post('/customer/rentals/rent', function ($request, $response) {
	$args = $request->getParsedBody();
	$errors = array();
	if(empty($args['movieID'])){
		array_push($errors, 'No movie set!');
	}
	if(empty($args['customerID'])){
		array_push($errors, 'No customer set!');
	}

	if(!empty($errors)){
		createResponse($errors);
	} else {
		createResponse(array('id' => createRental($args)));
	}
});

//////////////////////
//					//
//	Invoices 		//
//					//
//////////////////////

$app->post('/customer/invoice/pay', function ($request, $response) {
	$args = $request->getParsedBody();
	if(empty($args['rentals'])){
		createResponse(array('error' => 'No rentals found.'));
		return;
	}

	$rentals = $args['rentals'];

	$results = array();

	for ($i=0; $i < count($rentals); $i++) {
		$result = array();
		$result['id'] = $rentals[$i]['id'];
		$result['payed'] = true;
		payInvoice($rentals[$i]['id']);
		array_push($results, $result);
	};
	createResponse($results);
});

//////////////////////
//					//
//		Misc 		//
//					//
//////////////////////

$app->get('/version/', function ($request, $response, $args) {
	if($version = exec("git log --pretty=format:'%h' -n 1")){
		createResponse(array('git_version' => $version));
	} else {
		createResponse(array('error' => 'Could not fetch version.'));
	}
});
