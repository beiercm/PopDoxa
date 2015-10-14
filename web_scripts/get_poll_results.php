<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
		}
		else
		{
			$poll_id = $_GET['poll'];
		}

		print_r($argv);

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
		$stmt = "select count(user_vote) from poll_results where user_vote = 'y' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id)
		$stmt->execute();
		$yes_results = $stmt->fetchall();

		$stmt = "select count(user_vote) from poll_results where user_vote = 'n' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id)
		$stmt->execute();
		$no_results = $stmt->fetchall();

		$stmt = "select count(user_vote) from poll_results where user_vote = 'u' AND poll_id = :poll_id";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':poll_id', $poll_id)
		$stmt->execute();
		$undecided_results = $stmt->fetchall();

		$yes = $yes_results[0][0];
		$no = $no_results[0][1];
		$neutral = $undecided_results[0][2];

		$results['yes'] = $yes_results;
		$results['no'] = $no_results;
		$results['undecided'] = $undecided_results;

	}
?>