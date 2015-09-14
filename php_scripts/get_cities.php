<?php

	$path = chdir("/home/christopher/data");
	if($path)
	{
		$myfile = fopen("cblogin.txt", "r") or die("Unable to open login file!");
		$servername = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$username = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$password = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$dbname = trim(fgets($myfile, filesize("login.txt")), "\n.");
		fclose($myfile);
	}
	else
	{
		echo "Failed to retrieve login info, exiting...\n";
		return;
	}	

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
		$county = strtolower($county);

		$stmt = "SELECT cities.name FROM counties JOIN cities ON cities.county_id = counties.id WHERE counties.name = :county";

		$sth = $conn->prepare($stmt, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':county' => $county));
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$city = $result[$i][0];

			$url = "http://10.171.204.135/?state=florida/" . $county . "/" . $city;
			$city = str_replace("_", " ", $city);

			$city = ucwords($city);
			//echo $city ."\n". $url . $city . "\n";
			echo 		"<br />
				 		<a href = " . $url . ">"
				 		. $city .
				 		"</a>";
		} 
		
	}

?>