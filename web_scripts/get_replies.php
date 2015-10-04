<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$post = $argv[1];
		}
		else
		{
			$post = $_GET['post'];
		}

		get_replies($conn, $post);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_replies($conn, $post)
	{
		$query = "SELECT replies.author, replies.content, replies.ts FROM replies JOIN posts ON replies.post_id = posts.id WHERE posts.id = :post";

		$results = $conn->prepare($query);
		$results->bindparam(':post', $post);
		$results->execute();
		$results = $results->fetchAll();

		print_r($results);
	}


?>