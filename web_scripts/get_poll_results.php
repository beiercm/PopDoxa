<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
		}
		else
		{
			$poll_id = $_GET['poll_id'];
		}

		get_poll_results($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_results($conn, $poll_id)
	{
		$stmt = "select count(vote) from poll_results where vote = 'y' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
		$yes_results = $stmt->fetchall();

		$stmt = "select count(vote) from poll_results where vote = 'n' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
		$no_results = $stmt->fetchall();

		$stmt = "select count(vote) from poll_results where vote = 'u' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
		$undecided_results = $stmt->fetchall();

		$results[0]['vote'] = 'Yes';
		$results[0]['votes'] =  $yes_results[0][0];

		$results[1]['vote'] = 'No';
		$results[1]['votes'] =  $no_results[0][0];

		$results[2]['vote'] = 'Undecided';
		$results[2]['votes'] =  $undecided_results[0][0];

		echo json_encode($results);

	}
?>