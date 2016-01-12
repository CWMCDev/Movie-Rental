<?php
//Database.class.php bevat heel primitieve (mysqli)functies om communicatie te maken met een db.
//databasecomm.class.php bevat specifiekere functies die voor dit miniproject bedoelt zijn.
include_once(__DIR__ . "/Database.class.php");
include_once(__DIR__ . "/config.inc.php");


function getActor($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);

	$db->doSQL("SELECT * FROM `Actors` WHERE actor_id='".$id."'");
	$db->closeConnection();
	$result = $db->getRecord();

	if(empty($result))
		return false;
	else
		return $result;
}

function getActorNameLike($like){
	$db = new Database();
	$like = mysqli_real_escape_string($db->link, $like);

	$db->doSQL("SELECT * FROM Actors WHERE (firstname LIKE '%".$like."%' OR lastname LIKE '%".$like."%')");
	$db->closeConnection();
	$result = $db->getRecord();

	if(empty($result))
		return false;
	else
		return $result;
}

function getAllActors(){
	$db = new Database();
	$db->doSQL("SELECT * FROM `Actors`;");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(empty($result))
		return false;
	else
		return $result;
}

function getMoviesFromActor($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT * FROM `Films` WHERE film_id IN (SELECT film_id FROM `Plays_In` WHERE actor_id='".$id."');");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(empty($result))
		return false;
	else
		return $result;
	
}

?>