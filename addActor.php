<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//Check and insert into table
	if(isset($_POST["firstName"])){
		echo $_POST["firstName"];
	}
}
?>

<html>
<head>

</head>
<body>
<p> hi </p>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
        	First Name: <input type="text" name="firstName"><br>
        	Last Name: <input type="text" name="lastName"><br>
        	<input type="submit">
    	</form>
</body>
</html>
