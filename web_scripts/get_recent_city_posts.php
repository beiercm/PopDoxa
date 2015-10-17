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
				SELECT city, last_logout
				FROM users
				WHERE id = :user_id
				";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchAll();

		$user_city = $results[0]['city'];
		$last_logout = $results[0]['last_logout'];

		$query = "
				SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts
				join users
				on users.id = posts.author
				where posts.city = :user_city
				AND posts.ts > :last_logout;
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_city', $user_city);
		$query->bindparam(':last_logout', $last_logout);
		$query->execute();

		$results = $query->fetchAll();
		
		print_r($results);

	}
?>