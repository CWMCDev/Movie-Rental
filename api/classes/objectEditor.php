<?php

function editActor($actor){
	$birthDate = new DateTime($actor['birthdate']);
	$actor['birthdate'] = $birthDate->format('d F Y');
	$actor['birthyear'] = $birthDate->format('Y');
	
	return $actor;
}

?>