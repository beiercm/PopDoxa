<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$state_id = $argv[1];
			$county_id = $argv[2];
			$city_id = $argv[3];
		}
			
		else
		{
			if(isset($_GET['state']))
				$state_id = $_GET['state'];
			else $state_id = -1;
			
			if(isset($_GET['county']))
				$county_id = $_GET['county'];	
			else
				$county_id = -1;
			
			if(isset($_GET['city']))
				$city_id = $_GET['city'];
			else $city_id = -1;
		}
			
		get_recent_state_posts($conn, $state_id, $county_id, $city_id);
		
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_recent_state_posts($conn, $state_id, $county_id, $city_id)
	{
		if(strcmp($state_id, '-1'))
		{
			$query = $conn->prepare("SELECT users.username,posts.title
									from posts
									join users
									where posts.author = users.id 
									AND posts.state = :state_id
									AND posts.county = -1
									ORDER BY posts.ts DESC LIMIT 5;");
			$query->bindparam(':state_id', $state_id);
		}

		if(strcmp($county_id, '-1'))
		{
			$query = $conn->prepare("SELECT users.username,posts.title, posts.id
									from posts
									join users
									where posts.author = users.id 
									AND posts.county = :county_id
									AND posts.city = -1
									ORDER BY posts.ts DESC LIMIT 5;");
			$query->bindparam(':county_id', $county_id);
		}

		if(strcmp($city_id, '-1'))
		{
			$query = $conn->prepare("SELECT users.username,posts.title, posts.id
									from posts
									join users
									where posts.author = users.id 
									AND posts.city = :city_id
									ORDER BY posts.ts DESC LIMIT 5;");
			$query->bindparam(':city_id', $city_id);
		}

		$query->execute();
		$results = $query->fetchAll();

		$length = count($results);

		for($i = 0; $i < $length; $i++)
		{

			$url = "10.171.204.135/topic_id= " . $results[$i]['id'];

			echo $result[$i]['id'];

			if($i == 0)
				echo "<div class = \"item active\" >
						<blockquote>		
							<a href =" . $url . "
								<div class = \"row\"
									<div class = \"col-sm-9\">
										<p>" . $results[$i]['title'] . "</p>
									<small>" . $results[$i]['username'] ."</small>
									</div
								</div>
							</a>
						</blockquote>
					</div>";
			else
			echo 	"<div class = \"item\" >
						<blockquote>		
							<a href =" . $url . "
								<div class = \"row\"
									<div class = \"col-sm-9\">
										<p>" . $results[$i]['title'] . "</p>
									<small>" . $results[$i]['username'] ."</small>
									</div
								</div>
							</a>
						</blockquote>
					</div>";
		} 		
	}
?>
