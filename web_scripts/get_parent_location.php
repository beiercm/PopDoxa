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
			$query = $conn->prepare("
				SELECT states.name, states.id
				FROM counties 
				JOIN states
				on counties.state_id = states.id
				WHERE counties.id = :county_id");
			$query->bindparam(':county_id', $county_id);
			$query->execute();
			$results = $query->fetchAll();
		}
		
		else if(!strcmp($county_id, "-1"))
		{
			$query = $conn->prepare("
				SELECT states.name, states.id, counties.name, counties.id
				FROM states
				JOIN counties
				ON counties.state_id = states.id
				JOIN cities
				ON cities.county_id = counties.id
				WHERE cities.id = 1;");
			$query->bindparam(':city_id', $city_id);
			$query->execute();
			$results = $query->fetchAll();

			$to_return['state'] = $results[0][0];
			$to_return['state_id'] = $results[0][1];
			$to_return['county'] = $results[0][2];
			$to_return['county_id'] = $results[0][3];
			$results = $to_return;
		}

		echo json_encode($results);
	}
?>
