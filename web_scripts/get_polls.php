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
			$query= $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.votes,posts.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.county = :county_id 
				AND polls.city = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':county_id', $county_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.votes,posts.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.city = :city_id 
				ORDER BY ". $order_by
				);

			$query->bindparam(':city_id', $city_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.votes,posts.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.state = :state_id 
				AND polls.county = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':state_id', $state_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		for($i = 0; $i < count($result); $i++)
		{
			$url = "/topic_id.html?post=". $result[$i]['id'];

			echo "<tr><td><a href ='" . $url . "'>" . $result[$i]['question'] . "</a><br>" . 
				$result[$i]['username'] . "</td><td>". $result[$i]['votes'] . "</td><td>" . 
				$result[$i]['replies'] . "</td><td>" . $result[$i]['ts'] . "</tr>";
		}
	}

?>
