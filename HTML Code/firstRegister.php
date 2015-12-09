<?php
	if( empty($_POST) ){

		?>

		<html>
			<head>
				<title> Register </title>
				<link rel="stylesheet" type="text/css" href="style.css"/>
			</head>
			<body>
				<form class="main" action="register.php" method="Post"> 
					<header> Register </header> 
					<p>
						<label for="firstname"> First Name: </label>
						<input type="text" name="firstname" required="required" placeholder="John" autofocus/>
					</p> 
					<p>
						<label for="lastname"> Last Name: </label>
						<input type="text" name="lastname" required="required" placeholder="Doe" autofocus/>
					</p>
					<p>
						<label for="username"> Username: </label>
						<input type="text" name="username" required="required" placeholder="User227" autofocus/>
					</p> 
					<p>
						<label for="password"> Password: </label>
						<input type="password" name="password" required="required" placeholder="P@ssw0rd"/>
					</p> 
					<p>
						<label for="email"> Email: </label>
						<input type="text" name="email" required="required" placeholder="Student@Knights.UCF.edu"/>
					</p>
					<p>
						<label for="state"> State: </label>
						<input type="text" name="state" required="required" placeholder="Florida"/>
					</p>
					<p>
						<label for="county"> County: </label>
						<input type="text" name="county" required="required" placeholder="Polk"/>
					</p>
					<p>
						<label for="city"> City: </label>
						<input type="text" name="city" required="required" placeholder="Lakeland"/>
					</p>
					<p>
						<label for="age"> Age: </label>
						<input type="text" name="age" required="required" placeholder="27"/>
					</p>
					<p>
						<label for="gender"> Gender: </label>
						<input type="text" name="gender" required="required" placeholder="Male"/>
					</p>
					<p class="button">
		  				<input type="submit" value="Register"/> 
					</p>
				</form>
			</body>
		</html>

		<?php
	}
	else{
		include_once('database.php');

		$form = $_POST;
		$first = $form[ 'firstname' ];
		$last = $form[ 'lastname' ];
		$username = $form[ 'username' ];
		$password = $form[ 'password' ];
		$email = $form[ 'email' ];
		$state = $form[ 'state' ];
		$county = $form[ 'county' ];
		$city = $form[ 'city' ];
		$age = $form[ 'age' ];
		$gender = $form[ 'gender' ];

			$query = $connection->prepare("SELECT username FROM users WHERE username = :username");
			$query->bindParam(':username', $username);
			$query->execute();

			if( $query->rowCount() > 0 ){
				echo "	<script> alert('Username Taken');
					window.location.href='register.php';
					</script>";				
			}
			else{
				$query = $connection->prepare( "INSERT INTO users ( first, last, username, password, email, state, county, city, age, gender ) VALUES ( :first, :last, :username, :password, :email, :state, :county, :city, :age, :gender  )" );	
				$result = $query->execute( array( ':first'=>$first, ':last'=>$last, ':username'=>$username, ':password'=>$password, ':email'=>$email, ':state'=>$state, ':county'=>$county, ':city'=>$city, ':age'=>$age, ':gender'=>$gender ) );	

				if ( $result ){
					header( 'Location: login.php' );
				}
			} 
	}
?>



