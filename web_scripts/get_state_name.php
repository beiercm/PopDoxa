<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
		}
		else
		{
			$state = $_GET['state'];
		}

		get_state_name($conn, $state);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_state_name($conn, $state)
	{
		$stmt = "SELECT name FROM states where id = :state";

		$sth = $conn->prepare($stmt);
		$sth->bindparam(':state', $state);
		$sth->execute();
		$result = $sth->fetchAll();
		
		echo $result[0]['name'];
		
	}

?>
