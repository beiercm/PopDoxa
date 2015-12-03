<?php
	include 'get_connection.php';
	
	$first = $_POST["first"];
	$last = $_POST["last"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$age = $_POST["age"];
	$gender = $_POST["gender"];
	$state = $_POST["state"];
	$county = $_POST["county"];
	$city = $_POST["city"];
	
	$statement = mysqli_prepare($con, "INSERT INTO User(first, last, username,
	email, password, age, gender, state, county, city)" VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
	
	mysqli_stmt_bind_param($statement, "sssssissss", $first, $last, $username,
	$email, $password, $age, $gender, $state, $county, $city);
	
	mysqli_stmt_execute($statement);
	
	mysqli_stmt_close($statement);
	
	mysqli_close($con);

?>
