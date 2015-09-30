<?php
	include 'get_connection.php';	

	try {
		if(PHP_SAPI === 'cli')
		{
			$user_id = $argv[1];
		}
		else
		{
			$user_id = $_GET['user_id'];
		}

		get_opinions($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_opinions($conn, $user_id)
	{
		$query = "SELECT opinions.opin_name, user_opin.opinion FROM opinions JOIN user_opin ON opinions.id = user_opin.opin_id WHERE user_opin.user_id = :user_id;"
		$query->bindparam(':user_id', $user_id);
		$query->execute();
		$result = $query->fetchAll();

		print_r($result);
	}
?>
