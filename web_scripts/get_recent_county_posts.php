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
				SELECT county
				FROM users
				WHERE id = :user_id
				";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$user_county = $query->fetchAll()[0]['county'];

		$query = "
				SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts
				join users
				on users.id = posts.author
				where posts.county = :user_county
				AND posts.city = -1;
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_county', $user_county);
		$query->execute();

		$results = $query->fetchAll();
		
		print_r($results);

	}
?>