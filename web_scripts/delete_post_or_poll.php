<?php
	include 'get_connection.php';

	try {
		if(PHP_SAPI === 'cli')
		{
			$poll_id = $argv[1];
			
		}
		else
		{
			if(isset($_GET['poll_id']))
			{
				$poll_id = $_GET['poll_id'];
				delete_poll($poll_id);
			}

			if(isset($_GET['post_id']))
			{
				$post_id = $_GET['post_id'];
				delete_post($post_id);
			}
		}
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		return;
	}

	$conn = null;

	function delete_poll($conn, $poll_id)
	{
		$query = "
		DELETE polls, poll_replies
		FROM polls
		inner join poll_replies
		on poll_replies.poll_id = polls.id
		where polls.id = :poll_id
		and poll_replies.poll_id = :poll_id;
		";

		$query = $conn->prepare($query);
		$query->bindparam(':poll_id', $poll_id);
		$query->execute();
	}

	function delete_post($conn, $post_id)
	{
		$query = "
		DELETE posts, replies
		FROM posts
		inner join replies
		on replies.post_id = posts.id
		where posts.id = :post_id
		and replies.post_id = :post_id;
		";

		$query = $conn->prepare($query);
		$query->bindparam(':post_id', $post_id);
		$query->execute();
	}


?>
