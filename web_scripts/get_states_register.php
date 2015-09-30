<?php
	include 'get_connection.php';

	//The following will get the list of states in the DB and populate the dropdown for states
	
	get_urls($conn);
	$conn = null;
	
	function get_urls($conn)
	{
		$stmt = "SELECT name FROM states";

		$sth = $conn->prepare($stmt, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$state = $result[$i][0];

			$state = str_replace("_", " ", $state);

			$state = ucwords($state);

			echo    "<option value='" . $state . "'>" . $state . "</option>";

		} 		
	}
?>
