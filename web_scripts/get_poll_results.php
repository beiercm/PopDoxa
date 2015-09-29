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
		$stmt = "SELECT polls.yes,polls.no,polls.neutral FROM polls WHERE polls.id = " . $poll_id;

		$stmt = $conn->prepare($stmt);
		$stmt->execute();
		$results = $stmt->fetchall();

		$yes = $results[0][0];
		$no = $results[0][1];
		$neutral = $results[0][2];

		$res = "";
		$res = $res. $yes . "|" . $no . "|" . $neutral;

		echo $res;
	}
?>