<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
			$county = $argv[2];
			$city = $argv[3];
		}
		else
		{
			if(isset($_GET['state']))
				$state = $_GET['state'];
			else $state = -1;
			
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

		if($county != -1)
		{
			$stmt = "SELECT id from counties where state_id = :state AND name = :county" ;
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':state', $state_id);
			$stmt->bindparam(':county', $county);
			$stmt->execute();
			$results = $stmt->fetchAll();

			$county_id = $results[0][0];
			$where = "posts.county = " . $county_id. " AND posts.city = -1";

		}

		if($city != -1)
		{
			$stmt = "SELECT id from cities where county_id = :county AND name = :city";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':county', $county_id);
			$stmt->bindparam(':city', $city);
			$stmt->execute();
			$results = $stmt->fetchAll();

			$city_id = $results[0][0];
			$where = "posts.city = " . $city_id;
		}

		if($county == -1 && $city == -1)
			$where = "posts.state = " . $state_id . " AND posts.county = -1 AND posts.city = -1";


		$query = "SELECT posts.id, posts.title from posts JOIN states on states.id = posts.state where states.id = 9;";
		$result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

		$return = array();

		foreach($result as $row) {
			$return[] = array(	'id' => $row['id'],
								'title' => $row['title']);
		}

		echo json_encode($return);
		


		//  require ('ssp.class.php');
		// $columns = array(
		//   array( 'db' => 'title',	'dt' => 0 ),
		//   array( 'db' => 'views', 	'dt' => 1 ),
		//   array( 'db' => 'replies', 'dt' => 2 ),
		//   array( 'db' => 'ts', 		'dt' => 3 ),
		//   );

		//  $table = 'posts';
		//  $primaryKey = 'id';
		//  $joinQuery = "";

		//  echo json_encode(SSP::simple($_GET, $conn, $table, $primaryKey, $columns, $where));		
	}

?>
