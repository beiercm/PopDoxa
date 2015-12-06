<?php
	include 'get_connection.php';	

	try {
		if(PHP_SAPI === 'cli')
		{
			$short_name = $argv[1];
		}
		else
		{
			$short_name = $_GET['short_name'];
			$full_name = $_GET['full_name'];
		}

		create_group($conn, $short_name, $full_name);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function create_group($conn, $short_name, $full_name)
	{

		$query = "INSERT INTO opinions (short_name, full_name) values (:short_name, :full_name); ";

		$query = $conn->prepare($query);
		$query->bindparam(':short_name', $short_name);
		$query->bindparam(':full_name', $full_name);
		$query->execute();
	}
?>
