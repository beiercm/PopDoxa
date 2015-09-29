<?php

	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$post_id = $argv[1];
		}
		else
		{	
			$post_id = $_POST['post_id'];
		}	

		insert_post($conn, $post_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_post($conn, $post_id)
	{
		$stmt = $conn->prepare("UPDATE posts SET views = (views + 1) WHERE id = :post_id");
		$stmt->bindparam(':post_id', $post_id);
		$stmt->execute();
	}

?>
