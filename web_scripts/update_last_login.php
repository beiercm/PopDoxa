<?php

	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$user_id = $argv[1];
		}
		else
		{	
			$user_id = $_GET['user_id'];
		}	

		update_last_login($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function update_last_login($conn, $user_id)
	{
		$stmt = $conn->prepare("UPDATE users SET last_login = now() WHERE id = :user_id");
		$stmt->bindparam(':user_id', $user_id);
		$stmt->execute();

		echo "updated";
	}

?>
