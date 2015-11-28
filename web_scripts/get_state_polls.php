<?php
	include 'get_connection.php';

	try {
		
		get_states($conn);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_states($conn)
	{
		$stmt = "SELECT name, id FROM states";

		$sth = $conn->prepare($stmt, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$state = $result[$i]['name'];
			$id = $result[$i]['id'];

			$url = "http://10.171.204.135/state-polls.html?topic=" . $id;
			//echo $county ."\n". $url . $county . "\n";

			$state = str_replace("_", " ", $state);

			$state = ucwords($state);

			echo 		"<a class='list-group-item' href = " . $url . ">"
				 		. $state.
				 		"</a>";

		} 		
	}
?>
