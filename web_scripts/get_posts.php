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

	function get_posts($conn, $state_id, $county_id, $city_id)
	{

		if($county_id != -1)
		{
			$query= $conn->prepare("SELECT posts.author,posts.title,posts.views,posts.replies,posts.ts from posts join counties on posts.counties = counties.id where  posts.county = :county_id AND posts.city = -1;");
			$query->bindparam(':county_id', $county_id);
		}

		if($city_id != -1)
		{
			$query = $conn->prepare("SELECT posts.author,posts.title,posts.views,posts.replies,posts.ts from posts join cities on posts.city = cities.id where  posts.city =  :city_id;");
			$query->bindparam(':city_id', $city_id);
		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare("SELECT posts.author,posts.title,posts.views,posts.replies,posts.ts from posts join states on posts.state = states.id where states.id = :state_id AND posts.county = -1 AND posts.city = -1;");
			$query->bindparam(':state_id', $state_id);
		}

		$query->execute();

		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$return = array();

		foreach($result as $row) {
			$return[] = array(	'author' => $row['author'],
								'title' => $row['title'],
								'views' => $row['views'],
								'replies' => $row['replies'],
								'ts' => $row['ts']
								);
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
