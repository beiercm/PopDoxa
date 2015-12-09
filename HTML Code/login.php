<?php
	session_start();
	if(isset($_SESSION["username"])){
		?>
		<div class="toprightcorner">
			Logged in as: <strong> <?php echo $_SESSION["username"]?> </strong>
			User ID: <strong> <?php echo $_SESSION["user_id"]?> </strong>
			State: <strong><?php echo $_SESSION["state"]?> </strong>
		</div>
		<?php
	}

	if( empty($_POST) ){
		?>

		<html>
			<head>
				<title> PopDoxa | Login </title>
				<link rel="shortcut icon" href="pic/icon.ico">
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
				<link href="css/login.css" rel="stylesheet" />
				<style type="text/css">
				body
				{
					background: url(pic/flag-647617.jpg);
    				background-repeat: no-repeat;
    				background-size: 100% 100%; 
				}

				.standardForm--login
				{
					background-color: white; 
					border-radius: 6px; 
				}

				#firstInput
				{
					margin-top: 20px; 
					margin-bottom: 20px; 
				}

				#secondInput
				{
					margin-bottom: 30px; 
				}
				h1
				{
					margin-top: 20px; 
				}
				.items
				{
					margin-top: 10%; 
				}
				.modal-header
				{
					border-bottom: none; 
				}
				.h4, h4
				{
					font-size: 25px; 
				}
				</style>
				<script type="text/javascript">
				function showModal()
				{
					$('#myModal').modal('show')
				}
				</script>
  			</head>
			<body>
				<div class="row" id="top">
			    	<div class="container">
						<div class="contents items">
						    <div class="Login LoginBase Module" id="Login-5">
						        <form class="main standardForm standardForm--login " action="login.php" method="Post">
						            <h1> Log in to PopDoxa </h1>
						                <ul class="userLogin">
						                    <li class="loginUsername">
						                        <input id="firstInput" autofocus class="email"
						                            type="text"
						                            name="username_or_email"
						                            required="required"
						                            placeholder="Username"
						                            autocomplete="username"/>
						                    </li>
						                    <li class="loginPassword">
						                        <input  id="secondInput" type="password"
						                            name="password"
						                            required="required"
						                            placeholder="Password"/>
						                    </li>
						                </ul>
						            <div class="formFooter">
						                <div class="formFooterButtons">
						                    <button class="Button Module btn hasText large primary rounded" id="Button-9" type="submit">    
						                        <span class="buttonText">Log in</span>
						                    </button>
						                </div>
						                <ul class="auxillaryLinks">
						                    <li><a href="javascript:void(0)" onclick="showModal();" class="forgotPassword"href="javascript:void(0)" onclick="showModal();">Forgot your password?</a></li>
						                    <li><a href="http://10.171.204.135/register.php">Sign up now</a></li>
						                </ul>
						            </div>
						        </form>
						    </div>
						</div>
			    	</div>
				</div>
				<!-- This portion is for the modal. If a password is lost --> 
				<div class="modal fade" id="myModal">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Let's find your PopDoxa account</h4>
				      </div>
				      <div class="modal-body" style="font-size: medium">
				        <p>What's your email, name or username?</p>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</body>
		</html>

		<?php
	}
	else{
		include_once('scripts/web_scripts/get_connection.php');

		$form = $_POST;
		$username = $form[ 'username_or_email' ];
		$password = $form[ 'password' ];

			$sql = $conn->prepare('SELECT COUNT(username) FROM users WHERE username=:username AND password=:password');
			$sql->bindParam(':username', $username);
			$sql->bindParam(':password', $password);
			$sql->execute();

			if ( $sql->fetchColumn() > 0 ){
				$query = $conn->prepare( "SELECT `id` FROM users WHERE username=:username LIMIT 1" );
				$query->bindparam(':username', $username);
				$query->execute();
				$results = $query->fetch();
//				$access = $results['access'];
				$userid = $results['id'];

				session_start();
				$_SESSION["username"] = $username;
				$_SESSION["user_id"] = $userid;
//				$_SESSION["access"] = $access;

				$query = $conn->prepare( "SELECT `state` FROM users WHERE username=:username LIMIT 1" );
				$query->bindparam(':username', $username);
				$query->execute();
				$results = $query->fetch();

				$state = $results['state'];
				$_SESSION["state"] = $state;


				$query = $conn->prepare( "SELECT `county` FROM users WHERE username=:username LIMIT 1" );
				$query->bindparam(':username', $username);
				$query->execute();
				$results = $query->fetch();
				$county = $results['county'];
				$_SESSION["county"] = $county;


				$query = $conn->prepare( "SELECT `city` FROM users WHERE username=:username LIMIT 1" );
				$query->bindparam(':username', $username);
				$query->execute();
				$results = $query->fetch();
				$city = $results['city'];
				$_SESSION["city"] = $city;

				header( 'Location: home.html' );
			}
			else{
				header( 'Location: login.php' );
			}
	}
?>







