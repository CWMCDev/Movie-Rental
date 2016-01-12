<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Search";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/actorTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/movieTemplate.php");

if(!empty($_GET['srch-term'])){
	$searchTerm = $_GET['srch-term'];

	//Search Actors;
    $actorObjs = getActorNameLike($searchTerm);

	if ($actorObjs == false){
		echo'
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">Found Actors</h3>
	            </div>
	            <div class="panel-body">
	            	<p>There are no actors with that name!</p>
	            </div>
	        </div>
	    </div>';
	} else {
		echo'
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">Found Actors</h3>
	            </div>
	            <div class="panel-body">';
	                if ($actorObjs == false){
	                    return $actorObjs;
	                }

	                while($actor = mysqli_fetch_array($actorObjs)){
	                    showInfoForActor($actor);
	                    echo '<div class="col-md-1"></div>';
	                }
	    echo '  </div>
	        </div>
	    </div>
	    ';
	}

	//Search Movies;
    $movieObjs = getMovieNameLike($searchTerm);

	if ($movieObjs == false){
		echo'
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">Found Movies</h3>
	            </div>
	            <div class="panel-body">
	            	<p>There are no movies with that name!</p>
	            </div>
	        </div>
	    </div>';
	} else {
		echo'
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">Found Movies</h3>
	            </div>
	            <div class="panel-body">';
	                if ($movieObjs == false){
	                    return $movieObjs;
	                }

	                while($movie = mysqli_fetch_array($movieObjs)){
	                    showInfoFormovie($movie ,5 ,3);
	                    echo '<div class="col-md-1"></div>';
	                }
	    echo '  </div>
	        </div>
	    </div>
	    ';
	}


}

?>