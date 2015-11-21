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

		$post_results = [];

		for($i = 0; $i < count($results); $i++)	
			if(strpos(strtolower($results[$i]['title']), strtolower($keyword)) !== false)
				$post_results[$results[$i]['id']] = $results[$i]['title'];

		$stmt = "SELECT id, question from polls;";

		$stmt = $conn->prepare($stmt);
		$stmt->execute();
		$results = $stmt->fetchall();

		$poll_results = [];

		for($i = 0; $i < count($results); $i++)	
			if(strpos(strtolower($results[$i]['question']), strtolower($keyword)) !== false)
				$poll_results[$results[$i]['id']] = $results[$i]['question'];

		$to_return['posts'] = $post_results;
		$to_return['polls'] = $poll_results;

		echo json_encode($to_return);
	}
?>
