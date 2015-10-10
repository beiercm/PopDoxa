<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$username = $argv[1];

		}
		else
		{
			if(isset($_GET['email']))
				get_user_id_w_email($conn, $_GET['email']);
			
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

	function get_user_id_w_email($conn, $email)
	{
		$query = $conn->prepare("SELECT id from users where email = :email");
		$query->bindparam(':email', $email);
		$query->execute();

		$results = $query->fetchAll();

		echo $results[0][0];
	}

	function get_user_id_w_username($conn, $username)
	{
		$query = $conn->prepare("SELECT id FROM users WHERE username = :username");
		$query->bindparam(':username', $username);
		$query->execute();

		$results = $query->fetchAll();

		echo $results[0][0];
	}
?>
