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

		get_urls($conn, $state);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_urls($conn, $state)
	{
		$state = strtolower($state);

		$stmt = "SELECT counties.name FROM counties JOIN states ON counties.state_id = states.id WHERE states.name = :state";

		$sth = $conn->prepare($stmt, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':state' => $state));
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$county = $result[$i][0];

			$url = "http://10.171.204.135/?page_id=688?topic=" . $state . "/" . $county;
			//echo $county ."\n". $url . $county . "\n";

			$county = str_replace("_", " ", $county);

			$county = ucwords($county);






			echo 		"<a href = " . $url . " class = 'list-group-item'>"
				 		. $county .
				 		"</a>";

		} 
		
	}

?>
