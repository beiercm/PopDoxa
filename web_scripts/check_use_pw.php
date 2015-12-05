<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$username = $argv[1];
			$password = $argv[2];
			get_user_id_w_username($conn, $username, $password);

		}
		else
		{		
		
		if(isset($_GET['username']))
			get_user_id_w_username($conn, $_GET['username']);			
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	
	function get_user_id_w_username($conn, $username, $password)
	{
		
		$query = "select password from users where username = :username";
		$query = $conn->prepare($query);
		$query->bindparam(':username', $username);
		$query->execute();
		$password_from_db = $query->fetchall();

		print_r($password_from_db);

		$password_from_db = password_hash($password_from_db[0]['password'], PASSWORD_DEFAULT);

		$verified = password_verify($password, $password_from_db);

		if($verified)
			echo "Success\n";
		else
			echo "Failure\n";
	}
?>
