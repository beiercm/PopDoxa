<?php

	include 'get_connection.php';

	try {
		$author = $_GET['author'];
		$question = $_GET['question'];

		$state = isset($_GET['state'])) ? $_GET['state'] : -1;
		$county = isset($_GET['county'])) ? $_GET['county'] : -1;
		$city = isset($_GET['city'])) ? $_GET['city'] : -1;

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
