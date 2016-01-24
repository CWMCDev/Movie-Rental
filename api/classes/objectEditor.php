<?php

function editActor($actor){
	$birthDate = new DateTime($actor['birthdate']);
	$actor['birthdate'] = $birthDate->format('d F Y');
	$actor['birthyear'] = $birthDate->format('Y');
	
	return $actor;
}

function createCustomer($data){
	$id = generateID(6);

	$data['id'] = $id;

	if(insertCustomer($data) != false){
		return $id;
	} else {
		return false;
	}
}

?>