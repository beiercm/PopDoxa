<?php
	include 'get_connection.php';
	get_states($conn);
	$conn = null;
	
	function get_states($conn)
	{
		$stmt = "SELECT name,id FROM states";
		$sth = $conn->prepare($stmt, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$result = $sth->fetchAll();
		$length = count($result);
		for($i = 0; $i < $length; $i++)
		{
			$url = "http://10.171.204.135/state.html?topic=" . $result[$i]['id'];
			//echo $county ."\n". $url . $county . "\n";
			$state = str_replace("_", " ", $result[$i]['name']);
			$state = ucwords($state);
			echo 		"<div class='col-sm-3 listStates'><a href = " . $url . ">"
				 		. $state.
				 		"</a></div>";
		} 		
		$resultJSON = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	}
?>