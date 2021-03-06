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
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'y'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'a'
			and pr.poll_id = :poll_id
			and pr.vote = 'y'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'n'
			and pr.poll_id = :poll_id
			and pr.vote = 'y';
			";

			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();
			$yes_results = $query->fetchall();

			$query = "
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'n'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'a'
			and pr.poll_id = :poll_id
			and pr.vote = 'n'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'n'
			and pr.poll_id = :poll_id
			and pr.vote = 'n';
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();
			$no_results = $query->fetchall();

			$query = "
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'u'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'a'
			and pr.poll_id = :poll_id
			and pr.vote = 'u'
			UNION
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			join polls as p
			on p.id = pr.poll_id
			where uo.opin_id = " . $i . "
			and uo.opinion = 'n'
			and pr.poll_id = :poll_id
			and pr.vote = 'u';
			";

			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();
			$undecided_results = $query->fetchall();

			$results[$yes_results[0]['opin_descrip']]['yes'] = $yes_results;
			$results[$yes_results[0]['opin_descrip']]['no'] = $no_results;
			$results[$yes_results[0]['opin_descrip']]['undecided'] = $undecided_results;

			

			// $query = 
			// "
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'f'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'y'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'a'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'y'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'n'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'y';
			// ";	

			// $query = $conn->prepare($query);
			// $query->bindparam(':poll_id', $poll_id);
			// $query->execute();

			// $yes_results = $query->fetchall();

			// $query = 
			// "
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'f'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'n'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'a'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'n'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'n'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'n';
			// ";	

			// $query = $conn->prepare($query);
			// $query->bindparam(':poll_id', $poll_id);
			// $query->execute();

			// $no_results = $query->fetchall();

			// $query = 
			// "
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'f'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'u'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'a'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'u'
			// UNION
			// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			// from user_opin as uo
			// join poll_results as pr
			// on uo.user_id = pr.user_id
			// join opinions as op
			// on uo.opin_id = op.id
			// where uo.opin_id = " . $i . "
			// and uo.opinion = 'n'
			// and pr.poll_id = :poll_id
			// and pr.vote = 'u';
			// ";	

			// $query = $conn->prepare($query);
			// $query->bindparam(':poll_id', $poll_id);
			// $query->execute();

			// $undecided_results = $query->fetchall();

			// $results['yes'] = $yes_results;
			// $results['no'] = $no_results;
			// $results['undecided'] = $undecided_results;

			// echo json_encode($results);

			// break;
		}


		echo json_encode($results);

		// $query = 
		// "
		// SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
		// from user_opin as uo
		// join poll_results as pr
		// on uo.user_id = pr.user_id
		// join opinions as op
		// on uo.opin_id = op.id
		// where uo.opin_id = :opin_id
		// and uo.opinion = :stance
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
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = " . strval($opin_id) . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'y';
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$yes_results = $query->fetchAll();

			$query = 
			"
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = " . strval($opin_id) . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'y';
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$no_results = $query->fetchAll();

			$query = 
			"
			SELECT op.opin_descrip, count(uo.user_id), uo.opinion, pr.vote
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = " . strval($opin_id) . "
			and uo.opinion = 'f'
			and pr.poll_id = :poll_id
			and pr.vote = 'y';
			";
			$query = $conn->prepare($query);
			$query->bindparam(':poll_id', $poll_id);
			$query->execute();

			$undecided_results = $query->fetchAll();
		}
		*/

	}
?>