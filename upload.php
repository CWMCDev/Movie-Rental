<?php
  function createResponse($data=array()) {
    if(isset($_GET['format']) && $_GET['format'] == 'xml') {
      $array = array('data'=>$data);
      $xml = new SimpleXMLElement('<response/>');
      array_walk_recursive($array, array ($xml, 'addChild'));
      echo $xml->asXML();
    } else {
      if(isset($_GET['callback'])) {
        echo $_GET['callback'].'(';
      }	
      echo json_encode($data, JSON_PRETTY_PRINT);
      if(isset($_GET['callback'])) {
        echo ')';
      }
    }
  }

  function crypto_rand_secure($min, $max){
    	$range = $max - $min;
    	if ($range < 1) return $min; // not so random...
    	$log = ceil(log($range, 2));
    	$bytes = (int) ($log / 8) + 1; // length in bytes
    	$bits = (int) $log + 1; // length in bits
    	$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    	do {
        	$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        	$rnd = $rnd & $filter; // discard irrelevant bits
    	} while ($rnd >= $range);
    	return $min + $rnd;
	}

  function generateID($length){
    	$id = "";
    	$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    	$codeAlphabet.= "0123456789";
    	$max = strlen($codeAlphabet) - 1;
    	for ($i=0; $i < $length; $i++) {
    	    $id .= $codeAlphabet[crypto_rand_secure(0, $max)];
    	}
    	return $id;
	}

  $target_dir = "movie/img/";
  $id =  generateID(6);
  $target_file = $target_dir . $id . "." . pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
		createResponse(array('error' => 'File is not a valid image.'));
        $uploadOk = 0;
    }
  }
  // Check if file already exists
  if (file_exists($target_file)) {
		createResponse(array('error' => 'Could not create movie, id already exists.'));
    $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		createResponse(array('error' => 'File is not a JPG, PNG or JPEG.'));
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
		createResponse(array('error' => 'Could not create movie.'));
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo file_get_contents('https://movie-rental.8t2.eu/api/movie/add/'.$id.'/'.$_POST['title'].'/'.$_POST['releaseDate'].'/'.$_POST['description'],false);
      }
  }
?>
