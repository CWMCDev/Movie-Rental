<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Search";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");

if(!empty($_GET['srch-term'])){
	$searchTerm = $_GET['srch-term'];

	//Search Actors;
    $actorObj = getActorNameLike($searchTerm);

	if ($actorObj == false){
		echo '<h3>There are no actors with that name known to us.</h3>';
	} else {
		echo '<h1>Actors:</h1>';
		while($actor = mysqli_fetch_array($actorObj)){
    		$id = $actor['actor_id'];
    		$firstName = $actor['firstname'];
    		$lastName = $actor['lastname'];
    		echo '<a href="/actor/getActor.php?id='.$id.'"><p>'.$firstName.' '.$lastName.'</p></a>';
    	}
	}


}

?>