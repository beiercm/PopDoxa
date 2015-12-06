<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$state = $argv[1];
			$county = $argv[2];
			$city = $argv[3];

			$sort_by = 'default';
		}
		else
		{
			if(isset($_GET['state']))
				$state = $_GET['state'];
			else $state = -1;
			
			if(isset($_GET['county']))
				$county = $_GET['county'];	
			else
				$county = -1;
			
			if(isset($_GET['city']))
				$city = $_GET['city'];
			else $city = -1;

			if(isset($_GET['sort_by']))
				$sort_by = $_GET['sort_by'];
			else
				$sort_by = 'default';

			if(isset($_GET['voted']))
				get_voted_polls($conn, $state, $county, $city, $sort_by, $_GET['user_id']);

			else if(isset($_GET['not_voted']))
				get_not_voted_polls($conn, $state, $county, $city, $sort_by, $_GET['user_id']);
			else
				get_all_polls($conn, $state, $county, $city, $sort_by);
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;
	
	function get_all_polls($conn, $state_id, $county_id, $city_id, $sort_by)
	{
		switch($sort_by) {
			case "title":
				$order_by = "polls.title ASC";
				break;

			case "views":
				$order_by = "polls.views DESC";
				break;

			default:
				$order_by = "polls.ts DESC";
				break;
		}


		if($county_id != -1)
		{
			$query= $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.county = :county_id 
				AND polls.city = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':county_id', $county_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.city = :city_id 
				ORDER BY ". $order_by
				);

			$query->bindparam(':city_id', $city_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id 
				where polls.state = :state_id 
				AND polls.county = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':state_id', $state_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		echo json_encode($result);

		// for($i = 0; $i < count($result); $i++)
		// {
		// 	$url = "http://10.171.204.135/PollResults/Poll_Question.php?poll_id=" . $result[$i]['id'];

		// 		echo "	<tr><td><a href ='" . $url . "'>" . $result[$i]['question'] . "</a>
		// 				<br>" . $result[$i]['username'] . "</td>
		// 			<td>". $result[$i]['views'] . "</td>
		// 			<td>" . $result[$i]['ts'] . "</td></tr>";
		// }
	}

	function get_voted_polls($conn, $state_id, $county_id, $city_id, $sort_by, $user_id)
	{
		switch($sort_by) {
			case "title":
				$order_by = "polls.title ASC";
				break;

			case "views":
				$order_by = "polls.views DESC";
				break;

			default:
				$order_by = "polls.ts DESC";
				break;
		}


		if($county_id != -1)
		{
			$query= $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id
				join poll_results as pr
				on polls.id = pr.poll_id
				where pr.user_id = :user_id
				AND polls.county = :county_id 
				AND polls.city = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':county_id', $county_id);
			$query->bindparam(':user_id', $user_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id
				join poll_results as pr
				on polls.id = pr.poll_id
				where pr.user_id = :user_id
				AND polls.city = :city_id 
				ORDER BY ". $order_by
				);

			$query->bindparam(':city_id', $city_id);
			$query->bindparam(':user_id', $user_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username,polls.question,polls.id,polls.views,polls.ts 
				from polls 
				join users 
				on polls.author = users.id
				join poll_results as pr
				on polls.id = pr.poll_id
				where pr.user_id = :user_id
				and polls.state = :state_id 
				AND polls.county = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':state_id', $state_id);
			$query->bindparam(':user_id', $user_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		echo json_encode($result);
	}

	function get_not_voted_polls($conn, $state_id, $county_id, $city_id, $sort_by, $user_id)
	{
		switch($sort_by) {
			case "title":
				$order_by = "polls.title ASC";
				break;

			case "views":
				$order_by = "polls.views DESC";
				break;

			default:
				$order_by = "polls.ts DESC";
				break;
		}


		if($county_id != -1)
		{
			$query= $conn->prepare(
				"
				SELECT users.username, polls.question,polls.id,polls.views,polls.ts, pr.vote
				from polls
				join users
				on users.id = polls.author
				left join poll_results as pr
				on pr.user_id = :user_id
				and pr.poll_id = polls.id
				where pr.vote IS NULL
				AND polls.county = :county_id 
				AND polls.city = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':county_id', $county_id);
			$query->bindparam(':user_id', $user_id);
			
		}

		if($city_id != -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username, polls.question,polls.id,polls.views,polls.ts, pr.vote
				from polls
				join users
				on users.id = polls.author
				left join poll_results as pr
				on pr.user_id = :user_id
				and pr.poll_id = polls.id
				where pr.vote IS NULL
				AND polls.city = :city_id 
				ORDER BY ". $order_by
				);

			$query->bindparam(':city_id', $city_id);
			$query->bindparam(':user_id', $user_id);

		}

		if($county_id == -1 && $city_id == -1)
		{
			$query = $conn->prepare(
				"
				SELECT users.username, polls.question,polls.id,polls.views,polls.ts, pr.vote
				from polls
				join users
				on users.id = polls.author
				left join poll_results as pr
				on pr.user_id = :user_id
				and pr.poll_id = polls.id
				where pr.vote IS NULL
				and polls.state = :state_id 
				AND polls.county = -1
				ORDER BY ". $order_by
				);

			$query->bindparam(':state_id', $state_id);
			$query->bindparam(':user_id', $user_id);
		}

		$query->execute();

		$result = $query->fetchAll();

		echo json_encode($result);
	}

?>

