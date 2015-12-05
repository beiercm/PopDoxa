<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$user_id = $argv[1];

		}
		else
		{
			
			if(isset($_GET['user_id']))
				set_admin($conn, $_GET['user_id']);			
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function set_admin($conn, $user_id)
	{
		$query = $conn->prepare("SELECT count(id) from admins where user_id = :user_id");
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchall();

		if(count($results) > 0)
			echo "True"
		else
			echo "False"
	}
?>
