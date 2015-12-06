<?php

	include 'get_connection.php';
		
	get_feedback($conn);
	
	$conn = null;

	function get_feedback($conn)
	{
		$query = "
			SELECT users.username, fb.content, fb.ts 
			FROM feedback fb
			join users
			on users.id = fb.user_id;";
		$query = $conn->prepare($query);
		$query->execute();

		$results = $query->fetchall();

		for($i = 0; $i < count($results); $i++)
			echo "<tr><td>".$results[$i]['username'] . "</td><td>" . $results[$i]['content'] . "</td><td>" . $results[$i]['ts'] . "</td></tr>";

	}

?>
