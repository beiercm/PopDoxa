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

		get_user_locations($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_user_locations($conn, $user_id)
	{
		$query = "
				SELECT state, county, city
				from users
				where id = :user_id
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchAll();

		print_r($results);

		

	}
?>