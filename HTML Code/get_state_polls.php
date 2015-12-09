<?php
	include 'get_login.php';

	try {
		$servername = $login_info['servername'];
		$dbname = $login_info['dbname'];
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $login_info['username'], $login_info['password']);		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		get_urls($conn);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

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

			$url = "http://10.171.204.135/state-polls.html?topic=" . $state;
			//echo $county ."\n". $url . $county . "\n";

			$state = str_replace("_", " ", $state);

			$state = ucwords($state);

			echo 		"<a class='list-group-item' href = " . $url . ">"
				 		. $state.
				 		"</a>";

		} 		
	}
?>
