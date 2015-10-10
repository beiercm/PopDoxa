<?php

	include 'get_connection.php';

	try {
		$author = $_GET['author'];
		$title = $_GET['title'];
		$content = $_GET['content'];
		
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

		insert_post($conn, $author, $title, $content, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_post($conn, $author, $title, $content, $state, $county, $city)
	{
		$stmt = $conn->prepare("INSERT INTO posts (author, title, content, state, county, city) VALUES (:author,:title,:content,:state,:county,:city);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':title', $title);
		$stmt->bindparam(':content', $content);
		$stmt->bindparam(':state', $state);
		$stmt->bindparam(':county', $county);
		$stmt->bindparam(':city', $city);

		$stmt->execute();

	}

?>
