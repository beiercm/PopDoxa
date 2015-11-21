<?php
	include 'get_connection.php';	

	try {
		if(PHP_SAPI === 'cli')
		{
			$keyword = $argv[1];
		}
		else
		{
			$keyword = $_GET['keyword'];
		}

		search_posts($conn, $keyword);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function search_posts($conn, $keyword)
	{
		$stmt = "SELECT id, title from posts;";

		$stmt = $conn->prepare($stmt);
		$stmt->execute();
		$results = $stmt->fetchall();

		for($i = 0; $i < count($results); $i++)	
			if(strpos($results[$i]['title'], $keyword) !== false)
				$to_return[$results[$i]['id']] = $results[$i]['title'];

		echo json_encode($to_return);
	}
?>
