<?php

	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$author = $argv[1];
			$content = $argv[2];
			$post = $argv[3];
		}
		else
		{	
			$author = $_GET['author'];
			$content = $_GET['content'];
			$post = $_GET['post'];
		}	

		insert_reply($conn, $author, $content, $post);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_reply($conn, $author, $content, $post)
	{
		$stmt = $conn->prepare("INSERT INTO replies (author, content, post) VALUES (:author, :content,:post);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':content', $content);
		$stmt->bindparam(':post', $post);
		$stmt->execute();

		//Updates the parent post's last_post timestamp
		$stmt = $conn->prepare("UPDATE posts SET last_post = now() WHERE id = :post");
		$stmt->bindparam(':post', $post);
		$stmt->execute();
	}

?>
