<?php
$servername = "localhost";
$username = "localAdmin";
$password = "abc123";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully <br>";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$conn->query("USE Movie_Rental;");

function query($sql){
    $result = $conn->query($sql);

    if ($result->num_rows) {
        return mysqli_fetch_array($result);
    } else {
        echo "0 results";
    }
}
?>
