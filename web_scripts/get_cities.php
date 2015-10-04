<?php
	include 'get_connection.php';	

	try {
		if(PHP_SAPI === 'cli')
		{
			$county_id = $argv[1];
		}
		else
		{
			$county_id = $_GET['county_id'];
		}

		get_urls($conn, $county_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_urls($conn, $county_id)
	{
		$county_id = strtolower($county_id);

		$stmt = "SELECT cities.name FROM counties JOIN cities ON cities.county_id = counties.id WHERE counties.id = :county_id";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':county_id', $county_id);
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$city = $result[$i][0];

			$url = "http://10.171.204.135/?state=" . $state . "/" . $county_id . "/" . $city;
			$city = str_replace("_", " ", $city);

			$city = ucwords($city);
			//echo $city ."\n". $url . $city . "\n";
			echo 		"<a href = " . $url . " class='list-group-item'>"
				 		. $city .
				 		"</a>";
		}		
	}
?>