<?php

	$path = chdir("/home/christopher/data");
	if($path)
	{
		$myfile = fopen("login.txt", "r") or die("Unable to open login file!");
		$servername = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$username = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$password = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$dbname = trim(fgets($myfile, filesize("login.txt")), "\n.");
		fclose($myfile);
	}
	else
	{
		echo "Failed to retrieve login info, exiting...\n";
		return;
	}	

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);		
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
		$sth->execute(array(':state' => $state));
		$result = $sth->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$state = $result[$i][0];

			$url = "http://10.171.204.135/?page_id=610?topic=" . $state;
			//echo $county ."\n". $url . $county . "\n";

			$state = str_replace("_", " ", $state);

			$state = ucwords($state);


			echo 		"<div class='col-sm-4 links-states'><a href = " . $url . ">"
				 		. $state.
				 		"</a></div>";

		} 		
	}
?>
