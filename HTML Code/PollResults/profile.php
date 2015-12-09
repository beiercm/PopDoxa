<?php
	$id = $_GET['id'];

	$split_id = explode('/', $id);
	$id = $split_id[0];

	header('Location: http://10.171.204.135/profile.php?id=' . $id);
?> 