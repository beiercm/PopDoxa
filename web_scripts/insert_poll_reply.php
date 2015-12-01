<?php

	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$author = $argv[1];
			$content = $argv[2];
			$poll = $argv[3];
		}
		else
		{	
			$author = $_GET['author'];
			$content = $_GET['content'];
			$poll = $_GET['poll'];
		}	

		insert_poll_reply($conn, $author, $content, $poll);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_poll_reply($conn, $author, $content, $poll)
	{
		$stmt = $conn->prepare("INSERT INTO poll_replies (author, content, poll_id) VALUES (:author, :content,:poll);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':content', $content);
		$stmt->bindparam(':poll', $poll);
		$stmt->execute();

		//Updates the parent poll's last_poll timestamp
		$stmt = $conn->prepare("UPDATE polls SET last_poll = now(), replies = replies + 1 WHERE id = :poll");
		$stmt->bindparam(':poll', $poll);
		$stmt->execute();
	}

?>
