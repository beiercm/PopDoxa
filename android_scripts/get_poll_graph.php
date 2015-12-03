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

		get_poll_id($conn, $poll_id);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function get_poll_id($conn, $poll_id)
	{
		$result = shell_exec('sudo python /home/christopher/popdoxa/PopDoxa/python_scripts/gen_android_pie_graph.py ' . escapeshellarg(json_encode($poll_id)));
		$resultData = json_decode($result, true);

		echo $resultData;
	}	
?>
