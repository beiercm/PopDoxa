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

		$author = $_POST['author'];
		$title = $_POST['#038;title'];
		$content = $_POST['#038;content'];
		$state = strtolower($_POST['#038;state']);
		$county = -1;
		$city = -1;

		var_dump($_POST);

		insert_post($conn, $author, $title, $content, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function insert_post($conn, $author, $title, $content, $state, $county, $city)
	{
		$stmt = $conn->prepare("INSERT INTO posts (author, title, content, state, county, city) VALUES (:author,:title,:content,:state,:county,:city);");
		$stmt->bindparam(':author', $author);
		$stmt->bindparam(':title', $title);
		$stmt->bindparam(':content', $content);
		$stmt->bindparam(':state', $state);
		$stmt->bindparam(':county', $county);
		$stmt->bindparam(':city', $city);

		$stmt->execute();

		echo "Here";
		
	}

?>
