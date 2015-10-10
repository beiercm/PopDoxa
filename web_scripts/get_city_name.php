<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$city = $argv[1];
		}
		else
		{
			$city = $_GET['city'];
		}

		get_city_name($conn, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_city_name($conn, $city)
	{
		$stmt = "SELECT name FROM cities where id = :city";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':city', $city);
		$sth->execute();
		$result = $sth->fetchAll();
		
		echo $result[0]['name'];
		
	}

?>
