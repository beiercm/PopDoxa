<?php
	session_start();
	session_unset(); 
	session_destroy(); 
	header( 'Location: home.html' );
?>

<html>
	<head>
		<title>Logged Out</title>
		<link rel="shortcut icon" href="register.ico">
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<form class="main" action="home.html" method="Post"> 
			<p class="continuelabel">
				<label> Account logged out. </label>
			</p>
			<p class="button"> 
				<input type="submit" value="Main Menu"/> 
			</p>
		</form>
	</body>
</html>


