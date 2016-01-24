<?php
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

    function escapeArray($db, $array){
        foreach ($array as $key => $value) {
            $array['key'] = mysqli_real_escape_string($db->link, $value);
        }
        return $array;
    }

    function isValidEmail($email) {
      return filter_var($email, FILTER_VALIDATE_EMAIL);
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
?>