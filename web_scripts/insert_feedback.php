<?php

	include 'get_connection.php';

	try {
		$author = $_POST['author'];
		$content = $_POST['#038;content'];
		
		insert_feedback($conn, $author, $content);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_post($conn, $author, $content)
	{
		$stmt = $conn->prepare("INSERT INTO feedback (author, content) VALUES (:author,:content);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':content', $content);
		
		$stmt->execute();
	}

?>
