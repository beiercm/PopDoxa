<?php

	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$author = $argv[1];
			$content = $argv[2];
			$post_id = $argv[3];
		}
		else
		{	
			$author = $_POST['author'];
			$content = $_POST['#038;content'];
			$post_id = $_POST['#038;post_id'];
		}	
		var_dump($_POST);

		insert_post($conn, $author, $content, $post_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_post($conn, $author, $content, $post_id)
	{
		$stmt = $conn->prepare("INSERT INTO replies (author, content, post_id) VALUES (:author, :content,:post_id);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':content', $content);
		$stmt->bindparam(':post_id', $post_id);
		$stmt->execute();

		//Updates the parent post's last_post timestamp
		$stmt = $conn->prepare("UPDATE posts SET last_post = now() WHERE id = :post_id");
		$stmt->bindparam(':post_id', $post_id);
		$stmt->execute();
	}

?>
