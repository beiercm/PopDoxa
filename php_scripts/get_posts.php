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
			$state = $argv[1];
			$county = $argv[2];
			$city = $argv[3];
		}
		else
		{
			$state = $_GET['state'];
			if(isset($_GET['county']))
				$county = $_GET['county'];	
			else
				$county = -1;
			if(isset($_GET['city']))
				$city = $_GET['city'];
			else $city = -1;
		}

		get_posts($conn, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_posts($conn, $state, $county, $city)
	{
		$state = strtolower($state);
		$county = strtolower($county);
		$city = strtolower($city);

		$stmt = "SELECT id from states where name = :state";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':state', $state);
		$stmt->execute();
		$results = $stmt->fetchAll();

		$state_id = $results[0][0];

		if($county == -1)
		{
			$stmt = "SELECT id from counties where state_id = :state AND name = :county" ;
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':state', $state_id);
			$stmt->bindparam(':county', $county);
			$stmt->execute();
			$results = $stmt->fetchAll();

			$county_id = $results[0][0];

		}
		else 
			$county_id = -1;

		if($city == -1)
		{
			$stmt = "SELECT id from cities where county_id = :county AND name = :city";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':county', $county_id);
			$stmt->bindparam(':city', $city);
			$stmt->execute();
			$results = $stmt->fetchAll();

			$city_id = $results[0][0];
		}
		else
			$city_id = -1;

		 require ('ssp.class.php');
		$columns = array(
		  array( 'db' => 'title',	'dt' => 0 ),
		  array( 'db' => 'views', 	'dt' => 1 ),
		  array( 'db' => 'replies', 'dt' => 2 ),
		  array( 'db' => 'ts', 		'dt' => 3 ),
		  );

		 $table = 'posts';
		 $primaryKey = 'id';
		 $where = "posts.state = " . $state_id ;// . " AND posts.county = " . $county_id . " AND posts.city = " . $city_id . ";";
		 $joinQuery = "";

		 echo json_encode(SSP::simple($_GET, $conn, $table, $primaryKey, $columns, $where));		
	}

?>
