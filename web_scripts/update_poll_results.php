<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
			$user_id = $argv[2];
			$vote = $argv[3];
		}
		else
		{
			$poll_id = $_GET['poll_id'];
			$user_id = $_GET['user_id'];
			$vote = $_GET['vote'];
		}

		update_poll_results($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function update_poll_results($conn, $poll_id, $user_id, $vote)
	{
		$query = "INSERT INTO poll_results (poll_id, user_id, user_vote) VALUES (:poll_id, :user_id, :vote)";

		$query = $conn->prepare($query);
		$query->bindparam(':poll_id', $poll_id);
		$query->bindparam(':user_id', $user_id);
		$query->bindparam(':vote', $vote);
		$query->execute();

	}


?>
