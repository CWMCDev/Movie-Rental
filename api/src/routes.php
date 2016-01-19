<?php
require __DIR__ . '/../classes/database/databasecomm.class.php';
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
	$actorData = getActor($args['actorId']);
	$actor = mysqli_fetch_array($actorData);
   createResponse($actor);
});

$app->get('/actor/search/{actorName}', function ($request, $response, $args) {
	$actorData = getActorNameLike($args['actorName']);
	$actors = array();

	while($actor = mysqli_fetch_array($actorData)){
    	array_push($actors, $actor);
    }

   createResponse($actors);
});

$app->get('/actors/random/{amount}', function ($request, $response, $args) {
	$actorData = getRandomActors($args['amount']);
	$actors = array();

	while($actor = mysqli_fetch_array($actorData)){
    	array_push($actors, $actor);
    }   

    createResponse($actors);
});

$app->get('/actors/', function ($request, $response, $args) {
	$actorData = getAllActors();
	$actors = array();

	while($actor = mysqli_fetch_array($actorData)){
    	array_push($actors, $actor);
    }

   createResponse($actors);
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
		//error
	}
});

$app->get('/movie/search/{movieName}', function ($request, $response, $args) {
	$movieData = getmovieNameLike($args['movieName']);
	$movies = array();

	while($movie = mysqli_fetch_array($movieData)){
    	array_push($movies, $movie);
    }

   createResponse($movies);
});

$app->get('/movies/random/{amount}', function ($request, $response, $args) {
	$movieData = getRandommovies($args['amount']);
	$movies = array();

	while($movie = mysqli_fetch_array($movieData)){
    	array_push($movies, $movie);
    }   

    createResponse($movies);
});

$app->get('/movies/', function ($request, $response, $args) {
	$movieData = getAllmovies();
	$movies = array();

	while($movie = mysqli_fetch_array($movieData)){
    	array_push($movies, $movie);
    }

   createResponse($movies);
});

$app->get('/movies/actor/{actorId}', function ($request, $response, $args) {
	$movieData = getMoviesFromActor($args['actorId']);
	$movies = array();

	while($movie = mysqli_fetch_array($movieData)){
    	array_push($movies, $movie);
    }

   createResponse($movies);
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
