<?php

	include 'get_connection.php';

	try {
		$author = $_GET['author'];
		$question = $_GET['question'];

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

		insert_poll($conn, $author, $question, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_poll($conn, $author, $question, $content, $state, $county, $city)
	{
		echo $city;
		$query = "INSERT INTO polls (author, question, state, county, city) VALUES (:author,:question,:state,:county,:city);";
		
		$stmt = $conn->prepare($query);
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':question', $question);
		$stmt->bindparam(':state', $state);
		$stmt->bindparam(':county', $county);
		$stmt->bindparam(':city', $city);

		$stmt->execute();
	}
?>
