<?php

	include 'get_connection.php';

	try {
		$user_id = $_GET['user_id'];
		$poll_id = $_GET['poll_id'];
		$vote = $_GET['vote'];

		insert_vote($conn, $user_id, $poll_id, $vote);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_vote($conn, $user_id, $poll_id, $vote)
	{
		$stmt = "
			SELECT user_id, poll_id, vote
			FROM poll_results
			where user_id = :user_id
			AND poll_id = :poll_id;";

		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':user_id', $user_id);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
		$results = $stmt->fetchall();

		if(count($results) > 0)
			return;

		$stmt = "
			INSERT INTO poll_results 
			(user_id, poll_id, vote) 
			VALUES (:user_id,:poll_id,:vote);";

		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':user_id', $user_id);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->bindparam(':vote', $vote);

		$stmt->execute();
	}
?>
