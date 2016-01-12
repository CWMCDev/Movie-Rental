<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Search";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/actorTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/movieTemplate.php");

if(!empty($_GET['srch-term'])){
	$searchTerm = $_GET['srch-term'];

	//Search Actors;
    $actorObj = getActorNameLike($searchTerm);

	if ($actorObj == false){
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
	                if ($actorObj == false){
	                    return $actorObj;
	                }

	                while($actor = mysqli_fetch_array($actorObj)){
	                    showInfoForActor($actor);
	                    echo '<div class="col-md-1"></div>';
	                }
	    echo '  </div>
	        </div>
	    </div>
	    ';
	}


}

?>