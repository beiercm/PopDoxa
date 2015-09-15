<?php

	$path = chdir("/home/christopher/data");
	if($path)
	{
		$myfile = fopen("cblogin.txt", "r") or die("Unable to open login file!");
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

		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
			$county = $argv[2];
			$city = $argv[3];
		}
		else
		{
			$state = $_GET['state'];
			$county = $_GET['county'];
			$city = $_GET['city'];
		}

		get_posts($conn, $state, $county, $city);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_posts($conn, $state, $county, $city)
	{

//--------------------
		// // require ('ssp.class.php');
		// $columns = array(
		// //    array( 'db' => 'author', 	'dt' => 0 ),
		//     array( 'db' => 'title',		'dt' => 1 ),
		//     array( 'db' => 'views', 	'dt' => 2 ),
		//     array( 'db' => 'replies', 	'dt' => 3 ),
		//     array( 'db' => 'ts', 		'dt' => 4 ),
		//     );

		// $table = 'posts';
		// $p_key = 'id';
		// echo json_encode(SSP::simple($_GET, $conn, $table, $p_key, $columns));
//---------------------
		$state = strtolower($state);
		$county = strtolower($county);
		$city = strtolower($city);

		if(!strcmp($county, "-1"))
		{
			$query = "	SELECT users.username,posts.title,posts.ts,posts.views,posts.replies 
					FROM posts 
					JOIN states 
					ON states.id = posts.state 
					JOIN users ON users.id = posts.author 
					WHERE states.name = :state 
					";

		$stmt = $conn->prepare($query);
		$stmt->bindparam(':state', $state);

		}
		else if(!strcmp($city, "-1"))
		{
			$query = "	SELECT users.username,posts.title,posts.ts,posts.views,posts.replies 
					FROM posts 
					JOIN states 
					ON states.id = posts.state 
					JOIN counties 
					ON counties.id = posts.county
					JOIN users ON users.id = posts.author 
					WHERE states.name = :state 
					AND counties.name = :county
					
					";

		$stmt = $conn->prepare($query);
		$stmt->bindparam(':state', $state);
		$stmt->bindparam(':county', $county);
		}
		else
		{
			$query = "	SELECT users.username,posts.title,posts.ts,posts.views,posts.replies 
					FROM posts 
					JOIN states 
					ON states.id = posts.state 
					JOIN counties 
					ON counties.id = posts.county
					JOIN cities
					on cities.id = posts.city
					JOIN users ON users.id = posts.author 
					WHERE states.name = :state 
					AND counties.name = :county
					AND cities.name = :city;
					";

		$stmt = $conn->prepare($query);
		$stmt->bindparam(':state', $state);
		$stmt->bindparam(':county', $county);
		$stmt->bindparam(':city', $city);

		}

		
		$stmt->execute();
		$result = $stmt->fetchAll();

		$length = count($result);

		for($i = 0; $i < $length; $i++)
		{
			$output = 	sprintf("
						<tr>
							<td>
								<a href=\"#\"> %s </a>
								<div class =\"subtitle\">Start by: %s</div>
							</td>
							<td> %s </td>
							<td> %s </td>
							<td> %s </td>
						</tr>
						", $result[$i][1], $result[$i][0], $result[$i][3], $result[$i][4], $result[$i][2]);

			echo $output;

		}

		
		
	}

?>