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
			SELECT users.username, polls.question, polls.id
			from polls
			right join users
			where polls.state = users.state
			and users.id = :user_id
			UNION
			SELECT users.username, polls.question, polls.id
			from polls
			right join users
			where polls.county = users.county
			and users.id = :user_id
			UNION
			SELECT users.username, polls.question, polls.id
			from polls
			right join users
			where polls.city = users.city
			and users.id = :user_id;
			";
		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();
		$poll_results = $query->fetchall();

		$query = "
			SELECT users.username, posts.title, posts.id
			from posts
			right join users
			where posts.state = users.state
			and users.id = :user_id
			UNION
			SELECT users.username, posts.title, posts.id
			from posts
			right join users
			where posts.county = users.county
			and users.id = :user_id
			UNION
			SELECT users.username, posts.title, posts.id
			from posts
			right join users
			where posts.city = users.city
			and users.id = :user_id;
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