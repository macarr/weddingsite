<?php
//credentials
$servername = "localhost";
$username = "amurdero_webuser";
$password = "weddingpassword";
$dbname = "amurdero_wedding";

//create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($mysqli -> connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>