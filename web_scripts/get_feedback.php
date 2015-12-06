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
			echo "<tr><td>".$results[$i]['user_id'] . "</td><td>" . $results[$i]['content'] . "</td><td>" . $results[$i]['ts'] . "</td></tr>";

	}

?>
