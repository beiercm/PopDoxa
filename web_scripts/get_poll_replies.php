<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll = $argv[1];
		}
		else
		{
			$poll = $_GET['poll'];
		}

		get_poll_replies($conn, $poll);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_replies($conn, $poll)
	{

		$query = "SELECT users.username, pr.content, pr.ts 
				FROM poll_replies as pr
				JOIN users 
				ON pr.author = users.id WHERE pr.id = :poll";
		$poll_results = $conn->prepare($query);
		$poll_results->bindparam(':poll', $poll);
		$poll_results->execute();
		$poll_results = $poll_results->fetchAll();

		


		$query = "SELECT users.username, r.content, r.ts 
				FROM poll_replies as r
				JOIN polls 
				ON r.poll_id = polls.id 
				JOIN users 
				ON r.author = users.id 
				WHERE polls.id = :poll 
				ORDER BY r.ts DESC ";

		$results = $conn->prepare($query);
		$results->bindparam(':poll', $poll);
		$results->execute();
		$results = $results->fetchAll();

		$final_results = array_merge($poll_results, $results);

		echo json_encode($final_results);
	}


?>
