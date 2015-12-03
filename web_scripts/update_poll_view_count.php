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

		update_view_count($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function update_view_count($conn, $poll_id)
	{
		$stmt = $conn->prepare("UPDATE polls SET views = (views + 1) WHERE id = :poll_id");
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
	}

?>
