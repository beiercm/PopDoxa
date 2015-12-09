<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
			$county = $argv[2];
			$city = $argv[3];

			$sort_by = 'default';
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

			if(isset($_GET['sort_by']))
				$sort_by = $_GET['sort_by'];
			else
				$sort_by = 'default';
		}

		get_posts($conn, $state, $county, $city, $sort_by);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_posts($conn, $state_id, $county_id, $city_id, $sort_by)
	{
		switch($sort_by) {
			case "title":
				$order_by = "posts.title ASC";
				break;

			case "views":
				$order_by = "posts.views DESC";
				break;

			case "replies":
				$order_by = "posts.replies DESC";
				break;

			default:
				$order_by = "posts.ts DESC";
				break;
		}


		if($county_id != -1)
		{
			$query= $conn->prepare("SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.county = :county_id 
				AND posts.city = -1
				ORDER BY ". $order_by);

			$query->bindparam(':county_id', $county_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare("SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.city =  :city_id
				ORDER BY ". $order_by);

			$query->bindparam(':city_id', $city_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare("
				SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.state = :state_id 
				AND posts.county = -1
				ORDER BY ". $order_by);

			$query->bindparam(':state_id', $state_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		echo json_encode($result);
	}

?>
