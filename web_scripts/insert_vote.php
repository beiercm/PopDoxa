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
		$stmt = $conn->prepare("INSERT INTO poll_results (user_id, poll_id, vote) VALUES (:user_id,:poll_id,:vote;");
		$stmt->bindparam(':user_id', $user_id);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->bindparam(':vote', $vote);

		$stmt->execute();
	}
?>
