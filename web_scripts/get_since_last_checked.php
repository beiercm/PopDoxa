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
			SELECT polls.question, polls.id
			from polls
			right join users
			on polls.ts > users.last_checked
			where polls.state = users.state
			and users.id = :user_id
			UNION
			SELECT polls.question, polls.id
			from polls
			right join users
			on polls.ts > users.last_checked
			where polls.county = users.county
			and users.id = :user_id
			UNION
			SELECT polls.question, polls.id
			from polls
			right join users
			on polls.ts > users.last_checked
			where polls.city = users.city
			and users.id = :user_id;
			";
		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();
		$poll_results = $query->fetchall();

		$query = "
			SELECT posts.title, posts.id
			from posts
			right join users
			on posts.ts > users.last_checked
			where posts.state = users.state
			and users.id = :user_id
			UNION
			SELECT posts.title, posts.id
			from posts
			right join users
			on posts.ts > users.last_checked
			where posts.county = users.county
			and users.id = :user_id
			UNION
			SELECT posts.title, posts.id
			from posts
			right join users
			on posts.ts > users.last_checked
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