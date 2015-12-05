<?php

	include 'get_connection.php';
		
	get_feedback($conn);
	
	$conn = null;

	function get_feedback($conn)
	{
		$query = "SELECT user_id, content, ts FROM feedback";
		$query = $conn->prepare($query);
		$query->execute();

		$results = $query->fetchall();

		for($i = 0; $i < count($results); $i++)
			echo $results[$i]['user_id'] . "\n" . $results[$i]['content'] . "\n" . $results[$i]['ts'] . "\n";

	}

?>
