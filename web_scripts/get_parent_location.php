<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$county = $argv[1];
			$city = $argv[2];
		}
		else
		{
			
			if(isset($_GET['county']))
				$county = $_GET['county'];	
			else
				$county = -1;
			
			if(isset($_GET['city']))
				$city = $_GET['city'];
			else $city = -1;
		}

		get_parent_location($conn, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_parent_location($conn, $county_id, $city_id)
	{
		if(!strcmp($city_id, "-1"))
		{
			$query = $conn->prepare("SELECT state_id FROM counties WHERE id = :county_id");
			$query->bindparam(':county_id', $county_id);
			$query->execute();
			$results = $query->fetchAll();

			echo $results[0]['state_id'];
		}

		else if(!strcmp($county_id, "-1"))
		{
			$query = $conn->prepare("SELECT county_id FROM cities WHERE id = :city_id");
			$query->bindparam(':city_id', $city_id);
			$query->execute();
			$results = $query->fetchAll();

			echo $results[0]['county_id'];
		}
	}

?>
