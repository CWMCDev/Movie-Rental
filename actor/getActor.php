<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Actors";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");

if(!empty($_GET['id'])){
	$id = $_GET['id'];
	$firstName = '';
	$lastName = '';

    $actorObj = getActor($_GET['id']);

	if ($actorObj == false){
		return $actorObj;
	}

    while($actor = mysqli_fetch_array($actorObj)){
    	$firstName = $actor['firstname'];
    	$lastName = $actor['lastname'];
    }

    echo '<H1>'.$firstName.' '.$lastName.'</H1>';
    echo '<img src="img/'.$id.'.jpg"></img>';

    $movieObjs = getMoviesFromActor($id);

    while($movie = mysqli_fetch_array($movieObjs)){
    	echo '<h3>Title: '.$movie['name'].'</h3>';
    	echo '<p>'.$movie['description'].'</p>';
    	echo '<p>'.$movie['length'].' min</p>';
    	echo '<p>'.$movie['category'].'</p></br>';
    }


} else {
    //Show List Of Actors
}
?>
