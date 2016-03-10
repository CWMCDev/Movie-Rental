<?php
//Database.class.php bevat heel primitieve (mysqli)functies om communicatie te maken met een db.
//databasecomm.class.php bevat specifiekere functies die voor dit miniproject bedoelt zijn.
include_once(__DIR__ . "/Database.class.php");
include_once(__DIR__ . "/config.inc.php");

//////////////////////
//					//
//		ACTOR 		//
//					//
//////////////////////

function getActor($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);

	$db->doSQL("SELECT * FROM `Actors` WHERE actor_id='".$id."'");
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getActorNameLike($like){
	$db = new Database();
	$like = mysqli_real_escape_string($db->link, $like);

	$db->doSQL("SELECT * FROM Actors WHERE (firstname LIKE '%".$like."%' OR lastname LIKE '%".$like."%')");
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getRandomActors($limit = 10){
	$db = new Database();
	$limit = mysqli_real_escape_string($db->link, $limit);

	$db->doSQL("SELECT * FROM Actors ORDER BY RAND() LIMIT ".$limit);
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getAllActors(){
	$db = new Database();
	$db->doSQL("SELECT * FROM `Actors`;");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getMoviesFromActor($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT * FROM `Movies` WHERE movie_id IN (SELECT movie_id FROM `Plays_In` WHERE actor_id='".$id."');");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
	
}
//////////////////////
//					//
//		MOVIES 		//
//					//
//////////////////////

function addMovie($id, $name, $releaseDate, $description){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);

	$db->doSQL("INSERT INTO`Movies` VALUES ('".$id."','".$name."','".$releaseDate."','".$description."','3');");
	$db->closeConnection();
  
  return true;
}

function getMovie($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);

	$db->doSQL("SELECT * FROM `Movies` WHERE movie_id='".$id."'");
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getMovieNameLike($like){
	$db = new Database();
	$like = mysqli_real_escape_string($db->link, $like);

	$db->doSQL("SELECT * FROM Movies WHERE name LIKE '%".$like."%'");
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getRandomMovies($limit = 10){
	$db = new Database();
	$limit = mysqli_real_escape_string($db->link, $limit);

	$db->doSQL("SELECT * FROM Movies ORDER BY RAND() LIMIT ".$limit);
	$db->closeConnection();
	$result = $db->getRecord();

	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getAllMovies(){
	$db = new Database();
	$db->doSQL("SELECT * FROM `Movies`;");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getActorsFromMovie($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT `Actors`.`actor_id`, `Actors`.`firstname`, `Actors`.`lastname`, `Plays_In`.`character_name` FROM `Actors` INNER JOIN Plays_In ON `Actors`.`actor_id` = `Plays_In`.`actor_id` WHERE `Plays_In`.`movie_id`='".$id."';");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
	
}

function getCategoriesFromMovie($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT * FROM `Categories` WHERE movie_id='".$id."';");
	$db->closeConnection();
	$result = $db->getRecord();
	
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

//////////////////////
//					//
//	CATEGORIES 		//
//					//
//////////////////////

function getAllCategories(){
	$db = new Database();
	
	$db->doSQL("SHOW COLUMNS FROM Categories WHERE Field = 'category'");
	$db->closeConnection();
	$result = $db->getRecord();
	$data = '';
	while($results = mysqli_fetch_array($result)){
		$data = $results['Type'];
	}
	preg_match("/^enum\(\'(.*)\'\)$/", $data, $matches);
	$enum = explode("','", $matches[1]);
	return $enum;
}

function getMoviesFromCategory($category){
	$db = new Database();
	$category = mysqli_real_escape_string($db->link, $category);
	
	$db->doSQL("SELECT * FROM `Movies` WHERE movie_id IN (SELECT movie_id FROM `Categories` WHERE category='".$category."');");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

//////////////////////
//					//
//	Customers 		//
//					//
//////////////////////

function getUserFromID($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT * FROM `Customers` WHERE customer_id='".$id."';");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function getUsersFromEmail($email){
	$db = new Database();
	$email = mysqli_real_escape_string($db->link, $email);
	
	$db->doSQL("SELECT * FROM `Customers` WHERE email='".$email."';");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function insertCustomer($customer){
	$db = new Database();

	$customer = escapeArray($db, $customer);

	$db->doSQL("INSERT INTO `Customers` VALUES ('".$customer['id']."', '".$customer['firstName']."', '".$customer['lastName']."', '".$customer['email']."', '".$customer['phoneNumber']."', '".$customer['adress']['adress']."', '".$customer['adress']['postalCodeNumbers']."', '".$customer['adress']['postalCodeLetters']."', '".$customer['adress']['city']."', '".$customer['adress']['country']."')");
	$db->closeConnection();
	
	return true;
}

//////////////////////
//					//
//		Rental 		//
//					//
//////////////////////

function getRentalsFromUser($id){
	$db = new Database();
	$id = mysqli_real_escape_string($db->link, $id);
	
	$db->doSQL("SELECT Rentals.rental_id, Rentals.movie_id, Rentals.customer_id, Rentals.loan_date, Invoices.amount, Invoices.due_date, Invoices.payed, Movies.movie_id, Movies.name FROM Rentals 
	INNER JOIN Invoices ON Rentals.rental_id = Invoices.rental_id 
	INNER JOIN Movies ON Rentals.movie_id = Movies.movie_id WHERE customer_id = '".$id."';");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}

function insertRental($rental){
	$db = new Database();
	$rental = escapeArray($db, $rental);	
	
	$db->doSQL("INSERT INTO `Rentals` (`rental_id`, `movie_id`, `customer_id`, `loan_date`) VALUES ('".$rental['rentalID']."', '".$rental['movieID']."', '".$rental['customerID']."', '".$rental['loanDate']."')");
	$db->doSQL("INSERT INTO `Invoices` (`rental_id`, `amount`, `due_date`, `payed`) VALUES ('".$rental['rentalID']."', '".$rental['amount']."', '".$rental['dueDate']."', '0')");
	$db->doSQL("INSERT INTO `Reminders` (`rental_id`, `first_reminder`, `second_reminder`) VALUES ('".$rental['rentalID']."', '0', '0')");
	$db->closeConnection();

	return true;
}

//////////////////////
//					//
//	Invoices 		//
//					//
//////////////////////

function payInvoice($rentalID){
	$db = new Database();
	$rentalID = mysqli_real_escape_string($db->link, $rentalID);
	
	$db->doSQL("UPDATE `Invoices` SET `payed`=true WHERE `rental_id`='".$rentalID."';");
	$db->closeConnection();
	$result = $db->getRecord();
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return true;
	}
}

//////////////////////
//					//
//		Stats 		//
//					//
//////////////////////

function payedStats(){
	$db = new Database();
	
	$db->doSQL("SELECT `payed`, COUNT(`payed`) as 'amount' FROM `Invoices` GROUP BY `payed`");
	$db->closeConnection();
	$result = $db->getRecord();
	error_log(print_r($result,true));
	if(mysqli_num_rows($result) == 0){
		return false;
	} else {
		return $result;
	}
}
?>
