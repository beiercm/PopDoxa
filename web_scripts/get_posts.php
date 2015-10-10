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
			$query= $conn->prepare("SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.county = :county_id 
				AND posts.city = -1;");

			$query->bindparam(':county_id', $county_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare("SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.city =  :city_id;");

			$query->bindparam(':city_id', $city_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare("SELECT users.username,posts.title,posts.id,posts.views,posts.replies,posts.ts 
				from posts 
				join users 
				on posts.author = users.id 
				where posts.state = :state_id 
				AND posts.county = -1;");

			$query->bindparam(':state_id', $state_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		for($i = 0; $i < count($result); $i++)
		{
			$url = "10.171.204.135/topic_id.html?id= ". $result[$i]['id'];

			echo "<tr><td><a href = " . $url . "/a>" . $result[$i]['title'] . "</a><br>" . 
				$result[$i]['username'] . "</td><td>". $result[$i]['views'] . "</td><td>" . 
				$result[$i]['replies'] . "</td><td>" . $result[$i]['ts'] . "</tr>";
		}
	}

?>
