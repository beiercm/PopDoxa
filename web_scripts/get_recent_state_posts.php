<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
			$state = $argv[1];
			
		else
			$state = $_GET['state'];
			
		get_recent_state_posts($conn, $state);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_recent_state_posts($conn, $state)
	{
		$state = strtolower($state);

		$stmt = "SELECT id from states where name = :state";
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':state', $state);
		$stmt->execute();
		$results = $stmt->fetchAll();

		$state_id = $results[0][0];

		

		require ('ssp.class.php');
		$columns = array(
		  array( 'db' => 'title',	'dt' => 0 ),
		  array( 'db' => 'views', 	'dt' => 1 ),
		  array( 'db' => 'replies', 'dt' => 2 ),
		  array( 'db' => 'ts', 		'dt' => 3 ),
		  );

		 $table = 'posts';
		 $primaryKey = 'id';
		 $where = "posts.state = " . $state_id . "ORDER BY posts.ts LIMIT 5";// . " AND posts.county = " . $county_id . " AND posts.city = " . $city_id . ";";
		 $joinQuery = "";

		 echo json_encode(SSP::simple($_GET, $conn, $table, $primaryKey, $columns, $where));		
	}

?>
