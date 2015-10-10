<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$county = $argv[1];
		}
		else
		{
			$county = $_GET['county'];
		}

		get_county_name($conn, $county);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_county_name($conn, $county)
	{
		$stmt = "SELECT name FROM counties where id = :county";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':county', $county);
		$sth->execute();
		$result = $sth->fetchAll();
		
		echo $result[0]['name'];
		
	}

?>
