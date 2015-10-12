<?php

	session_start();	
	if(isset($_SESSION["username"]))
	{
		echo $_SESSION["user_id"]; 
	}
	else
	{
		echo "false";
	}

?>







