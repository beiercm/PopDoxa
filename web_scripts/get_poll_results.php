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

			if(isset($_GET['opin_id']))
			{
				$opin_id = $_GET['opin_id'];
			}
			else
				$opin_id = -1;
		}

		get_poll_results($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_results($conn, $poll_id, $opin_id)
	{
		if(strcmp($opin_id, -1))
		{
			$stmt = "select count(vote) from poll_results where vote = 'y' AND poll_id = :poll_id";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->execute();
			$yes_results = $stmt->fetchall();

			$stmt = "select count(vote) from poll_results where vote = 'n' AND poll_id = :poll_id";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->execute();
			$no_results = $stmt->fetchall();

			$stmt = "select count(vote) from poll_results where vote = 'u' AND poll_id = :poll_id";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->execute();
			$undecided_results = $stmt->fetchall();

			$results['yes'] = $yes_results[0][0];
			$results['no'] = $no_results[0][0];
			$results['undecided'] = $undecided_results[0][0];

			echo json_encode($results);
		}
		else
		{
			$stmt = 
			"
			SELECT count(uo.user_id)
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = :opin_id
			and pr.poll_id = :poll_id
			and pr.vote = 'y';";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->bindparam(':opin_id', $opin_id);
			$stmt->execute();
			$yes_results = $stmt->fetchall();

			$stmt = 
			"
			SELECT count(uo.user_id)
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = :opin_id
			and pr.poll_id = :poll_id
			and pr.vote = 'n';";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->bindparam(':opin_id', $opin_id);
			$stmt->execute();
			$no_results = $stmt->fetchall();

			$stmt = 
			"
			SELECT count(uo.user_id)
			from user_opin as uo
			join poll_results as pr
			on uo.user_id = pr.user_id
			join opinions as op
			on uo.opin_id = op.id
			where uo.opin_id = :opin_id
			and pr.poll_id = :poll_id
			and pr.vote = 'n';";
			$stmt = $conn->prepare($stmt);
			$stmt->bindparam(':poll_id', $poll_id);
			$stmt->bindparam(':opin_id', $opin_id);
			$stmt->execute();
			$undecided_results = $stmt->fetchall();

			$results['yes'] = $yes_results[0][0];
			$results['no'] = $no_results[0][0];
			$results['undecided'] = $undecided_results[0][0];

			echo json_encode($results);
		}
	}
?>