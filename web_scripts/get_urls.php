<?php

	include 'get_connection.php';

	try {
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
		$selection = "SELECT post_name,ID,post_parent from wp_posts where post_type = 'forum'";

		$selectStmt = $conn->prepare($selection);
		$selectStmt->execute();
		$result = $selectStmt->fetchAll();

		$length = count($result);

		$state_array = array();
		$city_array = array();

		for($i = 0; $i < $length; $i++) {

			if($result[$i][2] == 30) {

			$state = $result[$i][0];

			$state_url = "http://10.171.204.135/?forum=forum/" . $state;

			echo 	"<br />
			 		<a href = " . $state_url . ">"
			 		. $state .
			 		"</a>";

			for($j = 0; $j < $length; $j++)
			{
				if($result[$j][2] == $result[$i][1])
				{
					$city_array[$result[$j][0]] = "http://10.171.204.135/?forum=forum/" . $state . "/" . $result[$j][0];
					$city = $result[$j][0];
					$city_url = "http://10.171.204.135/?forum=forum/" . $state . "/" . $result[$j][0];

					echo 	"<br />
				 		<a href = " . $city_url . ">"
				 		. $city .
				 		"</a>";
				 }
			}

			$state_array[$state] = "http://10.171.204.135/?forum=forum/" . $state;
			}
		}

		// $final_array = array();
		// $final_array["states"] = $state_array;
		// $final_array["cities"] = $city_array;

		// print_r($final_array);
	}

?>
