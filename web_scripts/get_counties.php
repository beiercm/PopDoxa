<?php
	include 'get_connection.php';

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

		$stmt = "SELECT counties.id, counties.name FROM counties JOIN states ON counties.state_id = :state";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':state', $state);
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		print_r($result);

		for($i = 0; $i < $length; $i++)
		{
			$url = "http://10.171.204.135/?page_id=688?topic=" . $state . "/" . $result[$i]['id'];
			//echo $county ."\n". $url . $county . "\n";

			$county = str_replace("_", " ", $result[$i]['name']);

			$county = ucwords($county);






			// echo 		"<a href = " . $url . " class = 'list-group-item'>"
			// 	 		. $county .
			// 	 		"</a>";

		} 
		
	}

?>
