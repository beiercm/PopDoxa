<?php

	$servername = "localhost";
	$username = "root";
	$password = "popdoxasd";
	$dbname = "wordpress";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		selectData($conn);

	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function selectData($conn)
	{
		$selection = "SELECT post_name,ID,post_parent from wp_posts where post_type = 'forum'";

		$selectStmt = $conn->prepare($selection);
		$selectStmt->execute();
		$result = $selectStmt->fetchAll();

		$length = count($result);

		for(int i = 0; i < $length; i++)
			print_r($result[0][1] + "\n");		
	}

?>
