<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$user_id = $argv[1];
			test_admin($conn, $user_id);
		}
		else
		{
			
			if(isset($_GET['user_id']))
				test_admin($conn, $_GET['user_id']);			
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function test_admin($conn, $user_id)
	{
		$query = "SELECT id from admins where user_id = :user_id";

		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchall();

		print_r($results);

		echo (count($results['count(id)']) > 0) ? "True" : "False";
	}
?>
