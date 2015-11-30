<?php
	include 'get_connection.php';

	if(PHP_SAPI === 'cli')
	{
		$state_name = $argv[1];
	}
	else
	{
		$state_name = $_GET['state_name'];
	}

	get_counties_name($conn, $state_name);
	$conn = null;
	
	function get_counties_name($conn, $state_name)
	{
		$stmt = "SELECT name FROM counties where state_name = :state_name";

		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':state_name', $state_name);
		$stmt->execute();
		$result = $stmt->fetchAll();

		echo json_encode($result);
	}
?>
