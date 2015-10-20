<?php

	session_start();	
	if(isset($_SESSION["username"]))
	{
		echo $_SESSION["user_id"]. "/" . $_SESSION["state"]. "/" . $_SESSION["county"]. "/" . $_SESSION["city"]; 
	}
	else
	{
		echo "false";
	}

?>







