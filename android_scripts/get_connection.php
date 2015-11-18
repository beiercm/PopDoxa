<?php
	$path = chdir("/home/christopher/");
	if($path)
	{
		$myfile = fopen("login.txt", "r") or die("Unable to open login file!");
		$login_info = Array();
		$login_info['servername'] = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$login_info['username'] = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$login_info['password'] = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$login_info['dbname'] = trim(fgets($myfile, filesize("login.txt")), "\n.");
		fclose($myfile);
		$servername = $login_info['servername'];
		$dbname = $login_info['dbname'];
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $login_info['username'], $login_info['password']);		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}
	else
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}	
?>