<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$username = $argv[1];
			get_user_id_w_username($conn, $username);

		}
		else
		{		
		
		if(isset($_GET['username']))
			get_user_id_w_username($conn, $_GET['username']);			
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	
	function get_user_id_w_username($conn, $username)
	{
		//echo password_hash($username, PASSWORD_DEFAULT);

		echo password_verify($username, password_hash($username, PASSWORD_DEFAULT));
		$username2 = $username . "c";
		echo password_verify($username2, password_hash($username, PASSWORD_DEFAULT));
	}
?>
