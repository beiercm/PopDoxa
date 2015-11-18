<?php
	include 'get_connection.php';

	if(PHP_SAPI === 'cli')
		{
			$state_id = $argv[1];
		}
		else
		{
			$state_id = $_GET['state_id'];
		}

	get_counties_name($conn, $state_id);
	$conn = null;
	
	function get_counties_name($conn, $state_id)
	{
		$stmt = "SELECT name,id FROM counties";

		$sth = $conn->prepare($stmt);
		$sth->execute();
		$result = $sth->fetchAll();

		echo json_encode($result);
	}
?>
