<?php
	include 'get_connection.php';
	
	$username = $_POST["username"]; 
	$password = $_POST["password"];
	
	$statement = mysqli_prepare($con, "SELECT * FROM User WHERE username = ? AND password = ?");
	mysqli_stmt_bind_param($statement, "ss", $username, $password);
	mysqli_stmt_execute($statement);
	
	mysqli_stmt_store_result($statement);
	mysqli_stmt_bind_result($statement, $user_id, $first, $last, $username, $email, $password,
	$age, $gender, $state, $county, $city);
	
	$user = array();
	
	while(mysqli_stmt_fetch($statement)){
		$user[user_id] = $user_id;
		$user[first] = $first;
		$user[last] = $last;
		$user[username] = $username;
		$user[email] = $email;
		$user[password] = $password;
		$user[age] = $age;
		$user[state] = $state;
		$user[county] = $county;
		$user[city] = $city;
	}
	
	echo json_encode($user);
	
	mysqli_stmt_close($statement);

	
	mysqli_close($con)
?>
