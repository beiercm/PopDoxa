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
				SELECT county, last_logout
				FROM users
				WHERE id = :user_id
				";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchAll();

		$user_county = $results[0]['county'];
		$last_logout = $results[0]['last_logout'];

		$query = "
				SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts
				join users
				on users.id = posts.author
				where posts.county = :user_county
				AND posts.city = -1
				AND posts.ts > :last_logout;
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_county', $user_county);
		$query->bindparam(':last_logout', $last_logout);
		$query->execute();

		$results = $query->fetchAll();
		
		print_r($results);

	}
?>