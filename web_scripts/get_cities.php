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

		get_urls($conn, $county);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_urls($conn, $county)
	{

		$stmt = "SELECT name, id FROM cities where county_id = :county";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':county', $county);
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$city = $result[$i][0];

			$url = "http://10.171.204.135/city.html?topic=" . $result[$i]['id'];
			$city = str_replace("_", " ", $result[$i]['name']);

			$city = ucwords($city);
			//echo $city ."\n". $url . $city . "\n";
			echo 		"<a href = " . $url . " class='list-group-item'>"
				 		. $city .
				 		"</a>";
		}		
	}
?>
