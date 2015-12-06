<?php
	include 'get_connection.php';	

	try {
		if(PHP_SAPI === 'cli')
		{
			$opin_name = $argv[1];
		}
		else
		{
			$opin_name = $_GET['opin_name'];
			$opin_descrip = $_GET['opin_descrip'];
		}

		create_group($conn, $opin_name, $opin_descrip);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function create_group($conn, $opin_name, $opin_descrip)
	{

		$query = "INSERT INTO opinions (opin_name, opin_descrip) values (:opin_name, :opin_descrip); ";

		$query = $conn->prepare($query);
		$query->bindparam(':opin_name', $opin_name);
		$query->bindparam(':opin_descrip', $opin_descrip);
		$query->execute();
	}
?>
