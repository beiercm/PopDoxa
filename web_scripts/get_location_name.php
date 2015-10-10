<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$city = $argv[1];
		}
		else
		{
			if(isset($_GET['state']))
				$state = $_GET['state'];
			else 
				$state = -1;
			
			if(isset($_GET['county']))
				$county = $_GET['county'];	
			else
				$county = -1;
			
			if(isset($_GET['city']))
				$city = $_GET['city'];
			else 
				$city = -1;
		}

		get_loc_name($conn, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_loc_name($conn, $state, $county, $city)
	{
		if(strcmp($state, '-1'))
		{
			$query = $conn->prepare("SELECT name FROM states where id = :state;");
			$query->bindparam(':state', $state);
		}

		if(strcmp($county, '-1'))
		{
			$query = $conn->prepare("SELECT name FROM counties where id = :county;");
			$query->bindparam(':county', $county);
		}

		if(strcmp($city, '-1'))
		{
			$query = $conn->prepare("SELECT name FROM cities where id = :city");
			$query->bindparam(':city', $city);
		}

		$query->execute();

		$result = $query->fetchAll();

		echo $result[0]['name'];
		
	}

?>
