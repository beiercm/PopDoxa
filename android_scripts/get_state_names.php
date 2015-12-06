<?php
	include 'get_connection.php';

	get_state_names($conn);
	$conn = null;
	
	function get_state_names($conn)
	{
		$stmt = "SELECT name,id FROM states";

		$sth = $conn->prepare($stmt);
		$sth->execute();
		$result = $sth->fetchAll();

		echo json_encode($result);
	}
?>
