<?php
	include 'get_connection.php';

	if(PHP_SAPI === 'cli')
	{
		$county_id = $argv[1];
	}
	else
	{
		$county_id = $_GET['county_id'];
	}

	get_counties_name($conn, $county_id);
	$conn = null;
	
	function get_counties_name($conn, $county_id)
	{
		$stmt = "SELECT name,id FROM cities where county_id = :county_id";

		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':county_id', $county_id);
		$stmt->execute();
		$result = $stmt->fetchAll();

		echo json_encode($result);
	}
?>
