<?php

	$path = chdir("/home/christopher");
	if($path)
	{
		$myfile = fopen("login.txt", "r") or die("Unable to open file!");
		$servername = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$username = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$password = trim(fgets($myfile, filesize("login.txt")), "\n.");
		$dbname = trim(fgets($myfile, filesize("login.txt")), "\n.");
		fclose($myfile);

		print("Login info successfully retrieved\n");
	}
	else
	{
		echo "Failed to retrieve login info, exiting...\n";
		return;
	}

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);		
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// if (count($argv) < 2)
		// {
		// 	echo "\nPlease add an argument to command line\n\n";
		// 	return;
		// }

		get_poll_data($conn, 3);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_data($conn, $poll_id)
	{
		$selection = "select pollq_id,pollq_question,pollq_totalVotes from wp_pollsq where pollq_id = " . $poll_id;
		$selectStmt = $conn->prepare($selection);
		$selectStmt->execute();
		$result = $selectStmt->fetchAll();

		$selection2 = "select polla_votes from wp_pollsa where polla_qid = " . $poll_id;
		$selectStmt = $conn->prepare($selection2);
		$selectStmt->execute();
		$result2 = $selectStmt->fetchAll();

		$poll_id = $result[0][0];
		$poll_question = $result[0][1];
		$poll_total_votes = $result[0][2];

		$votes_yes = $result2[0][0];
		$votes_no = $result2[1][0];

		echo 	"Question: " . $poll_question . "\n" .
				"Total Votes: " . $poll_total_votes . "\n" .
				"Yes: ". $votes_yes . ", No: " . $votes_no . "\n\n";


	}
?>
