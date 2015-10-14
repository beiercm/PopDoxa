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

		get_poll_id($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_id($conn, $poll_id)
	{
		$query = "SELECT question FROM polls where id = :poll_id;";

		$query = $conn->prepare($query);
		$query->bindparam(':poll_id', $poll_id);
		$query->execute();

		$result = $query->fetchAll();

		echo $result[0]['question'];
	}


?>
