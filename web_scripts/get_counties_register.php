<?php
	include 'get_connection.php';
	//the following code goes into the db and retrieves all of the counties in the state 
	//this will be used in the register page
	try {
		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
		}
		else
		{
			$state = $_GET['state'];
		}

		get_counties($conn, $state);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_counties($conn, $state)
	{
		$state = strtolower($state);

		$stmt = "SELECT counties.name, counties.id FROM counties JOIN states ON counties.state_id = states.id WHERE states.name = :state";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':state', $state);
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$county = $result[$i][0];
			$county_id = $result[$i][1];

			$county = str_replace("_", " ", $county);

			$county = ucwords($county);

			echo 		"<option value='" . $county_id . "'>". $county . "</option>";

		} 
		
	}

?>
