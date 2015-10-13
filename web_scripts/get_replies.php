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

		$query = "SELECT users.username, posts.content, posts.ts FROM posts JOIN users ON posts.author = users.id where posts.id = :post";
		$post_results = $conn->prepare($query);
		$post_results->bindparam(':post', $post);
		$post_results->execute();
		$post_results = $post_results->fetchAll();

		


		$query = "SELECT users.username, replies.content, replies.ts FROM replies JOIN posts ON replies.post_id = posts.id JOIN users ON replies.author = users.id WHERE posts.id = :post";

		$results = $conn->prepare($query);
		$results->bindparam(':post', $post);
		$results->execute();
		$results = $results->fetchAll();

		$final_results = array_merge($post_results, $results);

		echo json_encode($final_results);
	}


?>
