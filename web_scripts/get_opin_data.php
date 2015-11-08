<?php
	include 'get_connection.php';

	try {
		
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
		}
		else
		{
			$poll_id = $_GET['poll_id'];
		}

		get_opin_data($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_opin_data($conn, $poll_id)
	{
		$query = "SELECT id from opinions";
		$query = $conn->prepare($query);
		$query->execute();
		$opinions = $query->fetchall();

		for($i = 1; $i <= count($opinions); $i++)
		{
			$query = "
			SELECT op.opin_descrip, count(pr.vote)
			from poll_results as pr 
			join user_opin as uo
			on uo.user_id = pr.user_id
			join opinions as op
			where op.id = uo.opin_id
			and pr.poll_id = :poll_id
			and uo.opinion = 'f'
			and uo.opin_id = " . $i . "
			union
			SELECT op.opin_descrip, count(pr.vote)
			from poll_results as pr 
			join user_opin as uo
			on uo.user_id = pr.user_id
			join opinions as op
			where op.id = uo.opin_id
			and pr.poll_id = :poll_id
			and uo.opinion = 'a'
			and uo.opin_id = " . $i . "
			union
			SELECT op.opin_descrip, count(pr.vote)
			from poll_results as pr 
			join user_opin as uo
			on uo.user_id = pr.user_id
			join opinions as op
			where op.id = uo.opin_id
			and pr.poll_id = :poll_id
			and uo.opinion = 'n'
			and uo.opin_id = " . $i . ";
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
			$results[$index]['Neutral'] = $these_results[2][2];
		}
		//unset($results);

// 		$results[0]['category2'] = "NRA";
// $results[0]['Yes'] = "100";
// $results[0]['No'] = "200";
// $results[0]['Undecided'] = "150";

// $results[1]['category2'] = "Tax";
// $results[1]['Yes'] = "500";
// $results[1]['No'] = "550";
// $results[1]['Undecided'] = "650";

// $results[2]['category2'] = "Education";
// $results[2]['Yes'] = "1000";
// $results[2]['No'] = "2000";
// $results[2]['Undecided'] = "1500";

		echo json_encode($results);

		// $query = 
		// "
		// SELECT op.opin_descrip, count(uo.user_id)
		// from user_opin as u
		// join opinions as op
		// on uo.opin_id = op.i
		// and pr.poll_id = :poll_id
		// and pr.vote = :vote;
		// ";
		// $query = $conn->prepare($query);
		// $query->bindparam(':opin_id', $opin_id);
		// $query->bindparam(':poll_id', $poll_id);
		// $query->bindparam(':stance', $stance);
		// $query->bindparam(':vote', $vote);
		// $query->execute();

		// $results = $query->fetchAll();

		// echo json_encode($results);


		/*
		$query = "SELECT opin_descrip from opinions";
		$query = $conn->prepare($query);
		$query->execute();

		$opinions = $query->fetchAll();

		for($opin_id = 0; $opin_id < count($opinions); $opin_id++)
		{
			$query = 
			"
			SELECT op.opin_descrip, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			and pr.poll_id = :poll_id;
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$yes_results = $query->fetchAll();

			$query = 
			"
			SELECT op.opin_descrip, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			and pr.poll_id = :poll_id;
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$no_results = $query->fetchAll();

			$query = 
			"
			SELECT op.opin_descrip, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			and pr.poll_id = :poll_id;
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$undecided_results = $query->fetchAll();
		}
		*/

	}
?>