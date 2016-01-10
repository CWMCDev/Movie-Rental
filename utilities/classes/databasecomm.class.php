<?php
//Database.class.php bevat heel primitieve (mysqli)functies om communicatie te maken met een db.
//databasecomm.class.php bevat specifiekere functies die voor dit miniproject bedoelt zijn.
include_once(__DIR__ . "/Database.class.php");
include_once(__DIR__ . "/config.inc.php");

var_dump(getAllActors());
function getAllActors(){
	$db = new Database();
	$db->doSQL("SELECT * FROM `Actors`;");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(empty($result))
		return false;
	else
		return mysqli_fetch_array($result);
}

?>