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

		get_recent_polls($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_recent_polls($conn, $user_id)
	{
		$query = "
				SELECT city
				FROM users
				WHERE id = :user_id
				";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$user_city = $query->fetchAll()[0]['city'];

		$query = "
				SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts
				join users
				on users.id = posts.author
				where posts.city = :user_city;
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_city', $user_city);
		$query->execute();

		$results = $query->fetchAll();
		
		print_r($results);

	}
?>