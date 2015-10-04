<?php

	include 'get_connection.php';

	try {
		$user_id = $_POST['user_id'];
		$content = $_POST['#038;content'];
		
		insert_feedback($conn, $user_id, $content);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_feedback($conn, $user_id, $content)
	{
		$stmt = $conn->prepare("INSERT INTO feedback (user_id, content) VALUES (:user_id,:content);");
		$stmt->bindparam(':user_id', $user_id);
		$stmt->bindparam(':content', $content);
		
		$stmt->execute();
	}

?>
