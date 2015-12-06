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

		get_since_last_checked($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_since_last_checked($conn, $user_id)
	{
		$query = "
			SELECT users.username, polls.question, polls.id, polls.ts
			from polls
			right join users
			on polls.author = users.id
			where polls.state = users.state
			limit 20
			UNION
			SELECT users.username, polls.question, polls.id, polls.ts
			from polls
			right join users
			on polls.author = users.id
			where polls.county = users.county
			limit 20
			UNION
			SELECT users.username, polls.question, polls.id, polls.ts
			from polls
			right join users
			on polls.author = users.id
			where polls.city = users.city
			limit 20;
			";
		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();
		$poll_results = $query->fetchall();

		$query = "
			SELECT users.username, posts.title, posts.id, posts.ts
			from posts
			right join users
			on posts.author = users.id
			where posts.state = users.state
			limit 20
			UNION
			SELECT users.username, posts.title, posts.id, posts.ts
			from posts
			right join users
			on posts.author = users.id
			where posts.county = users.county
			limit 20
			UNION
			SELECT users.username, posts.title, posts.id, posts.ts
			from posts
			right join users
			on posts.author = users.id
			where posts.city = users.city
			limit 20;
			";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();
		$post_results = $query->fetchall();

		$results['polls'] = $poll_results;
		$results['posts'] = $post_results;

		echo json_encode($results);
	}
?>