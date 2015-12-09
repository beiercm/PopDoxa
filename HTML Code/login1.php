<?php


	session_start();
	if(isset($_SESSION["username"])){
		?>
		<div class="toprightcorner">
			Logged in as: <strong> <?php echo $_SESSION["username"]?> </strong>
		</div>
		<?php
	}



	if( empty($_POST) ){

		?>

		<html>
			<head>
				<title> PopDoxa | Login </title>
				<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
				 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
				<!--[if lt IE 9]>
				 <script src="/applications/js/html5shiv.min.js"></script>
				 <script src="/applications/js/respond.min.js"></script>
				<![endif]-->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
				<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
				<!-- Latest compiled and minified JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
				<link href="css/pe-icon-7-stroke.css" rel="stylesheet" />
				<link href="css/ct-navbar.css" rel="stylesheet" />
				<style type="text/css">
				body
				{
					background: url(pic/usa-598261.jpg);
    				background-repeat: no-repeat;
    				background-size: 100% 100%; 
				}

				.main
				{
					background-color: transparent;
				}
				#formLayout
				{
 					background:rgba(255,255,255,0.8);
 					padding: 20px; 
 					top:50%;
     				left:50%;
     				margin:-100px 0 0 -150px;
				}
				</style>

  			</head>
			<body>
				<div class="row" id="top">
			    	<div class="container">
			    		<div id="formLayout">
							<form class="main" action="login.php" method="Post"> 
								<h1> Log in to PopDoxa </h1> 
								<p>
									<input type="text" name="username" required="required" placeholder="User227" autofocus/>
								</p>
								<p>
									<input type="password" name="password" required="required" placeholder="P@ssw0rd"/>
								</p>
								<p class="button"> 
					  				<input type="submit" value="Login"/> 
								</p>
							</form>
						</div>
			    	</div>
				</div>
			</body>
		</html>

		<?php
	}
	else{
		include_once('database.php');

		$form = $_POST;
		$username = $form[ 'username' ];
		$password = $form[ 'password' ];

				$sql = $connection->prepare('SELECT COUNT(username) FROM users WHERE username=:username AND password=:password');
			$sql->bindParam(':username', $username, PDO::PARAM_STR);
			$sql->bindParam(':password', $password, PDO::PARAM_STR);
			$sql->execute();

			if ( $sql->fetchColumn() > 0 ){

				$query = $connection->prepare( "SELECT `access` FROM users WHERE username=:username LIMIT 1" );
				$query->execute( array( 'username' => $username ) );
				$results = $query->fetch();

//				$access = $results['access'];

				session_start();
				$_SESSION["username"] = $username;
//				$_SESSION["access"] = $access;
				header( 'Location: home.html' );
			}
			else{
				header( 'Location: login.php' );
			}
	}
?>







