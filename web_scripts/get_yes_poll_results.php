<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
			// $opin_id = $argv[2];
			// $stance = $argv[3];
			// $vote = $argv[4];
		}
		else
		{
			$poll_id = $_GET['poll_id'];
			// $opin_id = $_GET['opin_id'];
			// $stance = $_GET['stance'];
			// $vote = $_GET['vote'];
		}

		get_poll_results($conn, $poll_id);//, $opin_id, $stance, $vote);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_results($conn, $poll_id)//, $opin_id, $stance, $vote)
	{
		$query = "SELECT id from opinions";
		$query = $conn->prepare($query);
		$query->execute();
		$opinions = $query->fetchall();

		for($i = 1; $i <= count($opinions); $i++)
		{
			$query = "
			SELECT op.opin_descrip, uo.opinion, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			join poll_results as pr
			on pr.id = :poll_id
			where uo.opin_id = ". $i ."
			and uo.opinion = 'f'
			and pr.vote = 'y'
			UNION
			SELECT op.opin_descrip, uo.opinion, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			join poll_results as pr
			on pr.id = :poll_id
			where uo.opin_id = ". $i ."
			and uo.opinion = 'a'
			and pr.vote = 'y'
			UNION
			SELECT op.opin_descrip, uo.opinion, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			join poll_results as pr
			on pr.id = :poll_id
			where uo.opin_id = ". $i ."
			and uo.opinion = 'n'
			and pr.vote = 'y';
			";

			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();
			$these_results = $query->fetchall();

			$index = $i - 1;
			//array_push($results, $these_results);
			$results[$index]['category2'] = $these_results[0][0];
			$results[$index]['For'] = $these_results[0][2];
			$results[$index]['Against'] = $these_results[1][2];
			$results[$index]['Undecided'] = $these_results[2][2];
		}

		echo json_encode($results);
	}
?>