<?php


function createCustomer($data){
	$id = generateID(6);

	$data['id'] = $id;

	if(insertCustomer($data) != false){
		return $id;
	} else {
		return false;
	}
}

function editCustomer($customerData){
	$customer = array();
	$customer['customerID'] = $customerData['customer_id'];
	$customer['firstName'] = $customerData['first_name'];
	$customer['lastName'] = $customerData['last_name'];
	$customer['email'] = $customerData['email'];
	$customer['phoneNumber'] = $customerData['phone_number'];
	$customer['adress']['adress'] = $customerData['adress'];
	$customer['adress']['postalCodeNumbers'] = $customerData['postal_code_numbers'];
	$customer['adress']['postalCodeLetters'] = $customerData['postal_code_letters'];
	$customer['adress']['city'] = $customerData['city'];
	$customer['adress']['country'] = $customerData['country'];
	return $customer;
}

function createRental($data){ //Data: movieID & customerID
	$id = generateID(6);

	$data['rentalID'] = $id;
	$data['loanDate'] = date("Y-m-d");
	$data['dueDate'] = date("Y-m-d", strtotime("+1 month"));

	$data['amount'] = 3.00;

	if(insertRental($data) != false){
		return $id;
	} else {
		return false;
	}
}

function editRental($rentalData){
	$rental = array();
	$rental['id'] = $rentalData['rental_id'];
	$rental['movie']['id'] = $rentalData['movie_id'];
	$rental['movie']['title'] = $rentalData['name'];
	$rental['loanDate'] = $rentalData['loan_date'];
	$rental['invoice']['dueDate'] = $rentalData['due_date'];
	$rental['invoice']['amount'] = $rentalData['amount'];
	$rental['invoice']['payed'] = (bool) $rentalData['payed'];
	return $rental;
}
?>