<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$user_id = $argv[1];
		}
		else
		{
			$user_id = $_GET['user_id'];
		}

		get_recent_polls($conn, $user_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_recent_polls($conn, $user_id)
	{
		$query = "
				SELECT polls.id, polls.question, users.username
				from polls
				join users
				on users.county = polls.county
				where users.id = :user_id;
				";
		$query = $conn->prepare($query);
		$query->bindparam(':user_id', $user_id);
		$query->execute();

		$results = $query->fetchAll();
		
		for($i = 0; $i < count($results); $i++)
		{
			$url = "http://10.171.204.135/PollResults/Poll_Question.php?poll_id=" . $results[$i]['id'];

			echo " <a class='item' href='" . $url . "'>
	                <!-- Show question from the poll -->
	                    <div class='truncate1'>
	                        <div class='truncate2'> " 
	                        . $results[$i]['question'] . 
	                        "
	                    </div>
	                  </div>
	                    <div class='username'>
	                      Created by: ". $results[$i]['username'] ."
	                    </div>
	                </a>";
        }

	}
?>