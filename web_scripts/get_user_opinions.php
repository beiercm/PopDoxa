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
		
	}
?>
