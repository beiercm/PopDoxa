<?php
	if( empty($_POST) ){

		?>

		<html>
			<head>
				<title> PopDoxa | Register </title>
				<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
				 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
				<!--[if lt IE 9]>
				 <script src="/applications/js/html5shiv.min.js"></script>
				 <script src="/applications/js/respond.min.js"></script>
				<![endif]-->
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
				<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
				<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
				<link rel="stylesheet" href="https://s-passets-cache-ak0.pinimg.com/webapp/style/app/common/scss/bundle-desktop-main-c961dab7.css">
            	<link rel="stylesheet" href="https://s-passets-cache-ak0.pinimg.com/webapp/style/app/common/scss/bundle-desktop-modules0-a44f2365.css">
            	<link rel="stylesheet" href="https://s-passets-cache-ak0.pinimg.com/webapp/style/app/common/scss/bundle-desktop-modules1-7fe0bdef.css">
            	<link rel="stylesheet" href="https://s-passets-cache-ak0.pinimg.com/webapp/style/app/common/scss/bundle-desktop-modules2-b821b4e9.css">
            	<link rel="stylesheet" href="https://s-passets-cache-ak0.pinimg.com/webapp/style/app/common/scss/bundle-desktop-modules3-baf39c88.css">			
	            <style type="text/css">
				.formFooter .formFooterButtons
				{
					float: none; 
				}    	
				.Button.btn.primary, .Button.btn.primaryOnHover:hover, .Button.btn.primaryOnHover:focus, .Button.btn.primaryOnHover.active
				{
					width: 100%; 
				}
				#dropdownMenu
				{
					width: 100%;
					font-size: medium; 
					padding: 12px;
				}
				.formInlineCheckedSet
				{
					vertical-align: middle;
					display: inline-block;
				}
				.dropdown-menu
				{
					max-height: 400px; 
					overflow-y: auto;
				}
				.LoginBase .standardForm
				{
					background-color: white; 
					border-radius: 10px; 
				}
				.standardForm--login select
				{
					height: 48px; 
				}
				.formInlineCheckedSet label > span
				{
					font-size: large; 
				}
				body
				{
					background: url(pic/flag.jpg);
    				background-repeat: no-repeat;
    				background-size: 100% 100%; 
				}
				.error
				{
					border-color: red !important; 
				}
				#userAge
				{
					width: 45%; 
				}
    	        </style>
    	        <script type="text/javascript">
				$(document).ready(function(){
					$("#dropdownMenu").change(function(){
						document.getElementById("dropdownMenu2").innerHTML = ""; 
						$("#dropdownMenu2").append("<option disabled selected>Select a County</option>"); 
						populateCounties(this.value); 
						$("#dropdownCounties").show();  
						$("#dropdownCities").hide();  
					});
					$("#dropdownMenu2").change(function(){
						document.getElementById("dropdownMenu3").innerHTML = ""; 
						$("#dropdownMenu3").append("<option disabled selected>Select a City</option>"); 
						var x = document.getElementById("dropdownMenu2");
						var value = x.options[x.selectedIndex].value;
						populateCities(value); 
						$("#dropdownCities").show();  

					});

					populateStates(); 
				}); 

				function populateStates()
				{
					var xmlhttp; 
					if(window.XMLHttpRequest)
				    { //code for IE7+, Firefox, Chrome, Opera, Safari
				      xmlhttp = new XMLHttpRequest(); 
				    }
				    else
				    {//code for IE6, IE5
				      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
				    }
				    xmlhttp.onreadystatechange = function()
				    { 
					    if(xmlhttp.readyState==4 && xmlhttp.status == 200)
					    {
					       $("#dropdownMenu").append(xmlhttp.responseText); 
					    }
				    }
				    xmlhttp.open("GET", "/scripts/web_scripts/get_states_register.php", true); 
				    xmlhttp.send(); 
				}
				
				function populateCounties(state)
				{
					var xmlhttp; 
					if(window.XMLHttpRequest)
				    { //code for IE7+, Firefox, Chrome, Opera, Safari
				      xmlhttp = new XMLHttpRequest(); 
				    }
				    else
				    {//code for IE6, IE5
				      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
				    }
				    xmlhttp.onreadystatechange = function()
				    { 
					    if(xmlhttp.readyState==4 && xmlhttp.status == 200)
					    {
					       $("#dropdownMenu2").append(xmlhttp.responseText); 
					    }
				    }
				    xmlhttp.open("GET", "/scripts/web_scripts/get_counties_register.php?state=" + state, true); 
				    xmlhttp.send(); 
				}

				function populateCities(countyid)
				{
					var xmlhttp; 
					if(window.XMLHttpRequest)
				    { //code for IE7+, Firefox, Chrome, Opera, Safari
				      xmlhttp = new XMLHttpRequest(); 
				    }
				    else
				    {//code for IE6, IE5
				      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
				    }
				    xmlhttp.onreadystatechange = function()
				    { 
					    if(xmlhttp.readyState==4 && xmlhttp.status == 200)
					    {
					       $("#dropdownMenu3").append(xmlhttp.responseText); 
					    }
				    }
				    xmlhttp.open("GET", "/scripts/web_scripts/get_cities_register.php?county_id=" + countyid, true); 
				    xmlhttp.send(); 
				}
    	      	function next()
    	      	{	
    	      		$("#inputFirst").removeClass("error");
	   	      		$("#inputSecond").removeClass("error");
    	      		$("#inputUsername").removeClass("error");
    	      		$("#inputPassword").removeClass("error");
    	      		$("#inputEmail").removeClass("error");

    	      		var valid = true; 
    	      		if($("#inputFirst").val() == "")
    	      		{
    	      			valid = false;  
    	      			$("#inputFirst").addClass("error"); 
    	      		}
    	      		if($("#inputSecond").val() == "")
    	      		{
    	      			valid = false;
    	      			$("#inputSecond").addClass("error");
    	      		}
    	      		if($("#inputUsername").val() == "")
    	      		{
    	      			valid = false;
    	      			$("#inputUsername").addClass("error");
    	      		}
    	      		if($("#inputPassword").val() == "")
    	      		{
    	      			valid = false;
    	      			$("#inputPassword").addClass("error");
    	      		}
    	      		if($("#inputEmail").val() == "")
    	      		{
    	      			valid = false;
    	      			$("#inputEmail").addClass("error");
    	      		}

    	      		if(valid)
    	      		{
    	      			nextQuestions();
    	      			$("#requiredItems").hide();  
    	      		}
    	      		else
    	      		{
    	      			$("#requiredItems").show();  
    	      		}

    	      	}

    	      	function nextQuestions()
    	      	{
    	      		$("li.firstitems").hide(); 
    	      		$("#firstpart").hide(); 
    	      		$("#secondpart").show();
    	      		$("li.seconditems").show(); 
    	      	}

    	      	function back()
    	      	{
    	      		$("li.firstitems").show(); 
    	      		$("#firstpart").show(); 
    	      		$("#secondpart").hide();
    	      		$("li.seconditems").hide(); 
    	      	}
    	        </script>
        	</head>
			<body>
				<div class="row" id="top">
			    	<div class="container">
						<div class="contents items" style="margin-top:5%">
						    <div class="Login LoginBase Module" id="Login-5">
						        <form class="main standardForm standardForm--login " action="register.php" method="post">
						            <h1 style="text-align:center"> Welcome to PopDoxa! </h1>
						                <ul class="userLogin">
						                	<span style="display:none; color: red; margin-left: 30px; font-size: medium;" id="requiredItems">*Required</span>
							                    <li class="text firstitems">
							                	 <input id="inputFirst" type="text"
						                            class="textField name first"
	                    					        name="first_name"
	                            					id="userFullName"
	                            					placeholder="First Name"
	                            					autocomplete="name">
	                            				</li>
	                            				<li class="text firstitems">
							                	 <input id="inputSecond" type="text"
						                            class="textField name last"
	                    					        name="last_name"
	                            					id="userLastName"
	                            					placeholder="Last Name"
	                            					autocomplete="name">
	                            				</li>
							                    <li class="loginUsername firstitems">
							                        <input id="inputUsername" autofocus class="email"
							                            type="text"
							                            name="username_or_email"
							                            required="required"
							                            placeholder="Username"
							                            autocomplete="username"/>
							                    </li>
							                    <li class="loginPassword firstitems">
							                        <input  id="inputPassword" type="password"
							                            name="password"
							                            required="required"
							                            placeholder="Password"/>
							                    </li>
							                    <li class="textField firstitems">
							                        <input autofocus id="inputEmail" class="text"
							                            type="text"
							                            name="userEmail"
							                            required="required"
							                            placeholder="Email"
							                            autocomplete="email"/>
							                    </li>
							                    <li class="genderFormItem seconditems" style="display:none"><!-- Gender choices --> 
							                    	<fieldset class="fieldset">
	                    								<div class="formInputWrapper">
															<fieldset class="fieldset ageFieldRedesign" style="display:inline-block; width: 180px;">
                												<input type="text" 
                												class="textField age"
                        										name="age" 
                        										id="userAge"
                        										placeholder="Age" />
                											</fieldset>
    														<fieldset class="formInlineCheckedSet">
                												<ul>
                                                        			<li>                                    
																		<label>
                															<input name="gender" type="radio" value="male" />
            																<span class=" gender">Male</span>
																		</label>
																	</li>
																	<li>                                    
																		<label>
                															<input name="gender" type="radio" value="female" />
            																<span class=" gender ">Female</span>
            															</label>
																	</li>
                												</ul>
													        </fieldset>
                                                        </div>
             								       	</fieldset>
                								</li>
                								<li class="dropdown seconditems" style="display:none">
                									<select class="dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-expanded="true">
                										<option disabled selected>Select a State</option>
                									</select>
                								</li>
                								<li class="dropdown" id="dropdownCounties" style="display:none;">
                									<select class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
                										<option disabled selected>Loading ...</option>
                									</select>
                								</li>
                								<li class="dropdown" id="dropdownCities" style="display:none;">
                									<select class="dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-expanded="true">
                										<option disabled selected>Loading ...</option>
                									</select>
                								</li>
             								</ul>             
						            <div class="formFooter">
						                <div class="formFooterButtons">
						                    <span id="firstpart">
							                    <input value="Next" style="background-image:none; background-color:#5cb85c; border-color: #5cb85c" onClick="next()" class="Button Module btn hasText large primary rounded" id="Button-10" type="button" />
							                </span>
							                <span id="secondpart" style="display:none;">
							                    <button class="Button Module btn hasText large primary rounded" id="Button-9" type="submit">    
							                        <span class="buttonText">Submit</span>
							                    </button>
							                    <a style="color: #C0C0C0; margin-top: 20px; width: 100%; text-align: center;" href='javascript:;' onclick='back();'>Back<a/>
						                   	</span>
						                </div>
						            </div>
						        </form>
						    </div>
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



