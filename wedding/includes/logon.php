<?php
	session_start();
	$password = $_POST["password"];
	if($password == "mattandvickywedding") {
		$_SESSION["login"] = true;
		echo "Logged in. <br><br>";
		echo "<a href='/admin.php'>Admin page</a><br>";
		echo "<a href='/index.php'>Home page</a>";
	} else {
		echo "Login failed. <a href='/index.html'>Go away Hiltz.</a>";
	}
?>