<?php
	include 'get_connection.php';

	try {
		
		get_opin_data($conn);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_opin_data($conn)
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
			where uo.opin_id = ". $i ."
			and uo.opinion = 'f'
			UNION
			SELECT op.opin_descrip, uo.opinion, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = ". $i ."
			and uo.opinion = 'a'
			UNION
			SELECT op.opin_descrip, uo.opinion, count(uo.user_id)
			from user_opin as uo
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = ". $i ."
			and uo.opinion = 'n';
			";

			$query = $conn->prepare($query);
			$query->execute();
			$these_results = $query->fetchall();

			//array_push($results, $these_results);
			$results[$i]['category2'] = $these_results[0][0];
			$results[$i]['For'] = $these_results[0][2];
			$results[$i]['Against'] = $these_results[1][2];
			$results[$i]['Undecided'] = $these_results[2][2];


		}

		print_r($results);
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