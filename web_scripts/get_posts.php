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
			$url = "10.171.204.135/forum_id.html?city =". $city_id;
		}

		if($city_id != -1)
		{
			$query = $conn->prepare("SELECT posts.author,posts.title,posts.views,posts.replies,posts.ts from posts join cities on posts.city = cities.id where  posts.city =  :city_id;");
			$query->bindparam(':city_id', $city_id);

			$url = "10.171.204.135/forum_id.html?county =". $county_id;
		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare("SELECT posts.author,posts.title,posts.views,posts.replies,posts.ts from posts join states on posts.state = states.id where states.id = :state_id AND posts.county = -1 AND posts.city = -1;");
			$query->bindparam(':state_id', $state_id);
			$url = "10.171.204.135/forum_id.html?state =". $state_id;
		}

		$query->execute();

		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		for($i = 0; $i < count($result); $i++)
		{
			echo "<tr><td><a href = " . $url . ">" . $result['title'] . "</a><br>" . 
				$result['author'] . "</td><td>". $result['views'] . "</td><td>" . 
				$result['replies'] . "</td><td>" . $result['ts'] . "</tr>";
		}
	}

?>
