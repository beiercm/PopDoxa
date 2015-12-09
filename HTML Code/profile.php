<html>
	<head>
		<title>My Profile</title>  
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link href="css/pe-icon-7-stroke.css" rel="stylesheet" />
  <link href="css/ct-navbar.css" rel="stylesheet" />
  <link href="css/home.css" rel="stylesheet" />
  <link href="css/main.css" rel="stylesheet" />
  <script src="js/main.js"></script>


  <style type="text/css">
  .background
  {
  	background-color: #eee; 
  	padding: 20px; 
  }

  .height
  {
    height: 300px;
  }
  </style>
  <script type="text/javascript">

  //Set the carousel options
  $('#quote-carousel').carousel({
    pause: true,
    interval: 4000,
  });

  </script>
	</head>
	<body>

    <span id="navbarSection"></span>
    <div style='margin-top: 30px; margin-bottom: 150px;'>
    	<div style="text-align: center; margin-bottom: 10px"><h2>My Profile</h2></div>
	<form name="myform" action="profile.php?id=<?php echo $_GET['id'];?>" method="POST">
	  <div class="container">

			<div align="left">



<?php
	include 'scripts/web_scripts/get_connection.php'; 

    try {
        if(PHP_SAPI === 'cli')
        {
            $id = $argv[1];
        }
        else
        {
            $id = $_GET['id'];
        }

	if( !empty($_POST) ){
// 8/27/15
		set_info($conn, $id);
		set_opinions($conn, $id);
	}

	get_info($conn, $id);
        get_opinions($conn, $id);
    }
    catch (PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
        return;
    }

    $conn = null;
    function set_opinions($conn, $id)
    {
	$form = $_POST;

//************* this needs to be finished *****************//

        $query = "SELECT opinions.opin_descrip, user_opin.opinion FROM opinions JOIN user_opin ON opinions.id = user_opin.opin_id WHERE user_opin.user_id = :id;";
        $query = $conn->prepare($query);
        $query->bindparam(':id', $id);
        $query->execute();
        $query_results = $query->fetchAll();

        $length = count($query_results);

        for($i = 0; $i < $length; $i++)
        {
		$choice = "choice" . $i;
		$choice = $form[ $choice ];
echo $choice;

            	if($choice == 0)
            	{
echo "For";
            	}
            	else if($choice == 1)
            	{
echo "Against";
            	}
            	else
            	{         
echo "Neutral";
            	}
	}
    }

    function set_info($conn, $id)
    {
	$form = $_POST;

	$firstname = $form["firstname"];
	$lastname = $form["lastname"];
	$username = $form["username"];
	$password = $form["password"];
	$email = $form["email"];
	$age = $form["age"];
	$gender = $form["gender"];
	$stateName = $form["dropdownMenu"];
	$county_id = $form["dropdownMenu2"];
	$cityName = $form["dropdownMenu3"];

			$query = $conn->prepare("
				SELECT states.name, states.id
				FROM counties 
				JOIN states
				on counties.state_id = states.id
				WHERE counties.id = :county_id");
			$query->bindparam(':county_id', $county_id);
			$query->execute();
			$results = $query->fetchAll();

			$state_id = $results[0][1];

			$city_id = $form["dropdownMenu3"];
			$lowerCaseCityName = str_replace(" ", "_", strtolower($form["dropdownMenu3"]));
			echo "..." . $lowerCaseCityName . "...";

			$query = $conn->prepare("
				SELECT cities.id
				FROM cities
				WHERE county_id = :county_id AND name = :lowerCaseCityName");
			$query->bindparam(':county_id', $county_id);
			$query->bindparam(':lowerCaseCityName', $lowerCaseCityName);
			$query->execute();
			$results = $query->fetchAll();

			$city_id = $results[0][0];

    }

    function get_opinions($conn, $id)
    {
        $query = "SELECT opinions.opin_descrip, user_opin.opinion FROM opinions JOIN user_opin ON opinions.id = user_opin.opin_id WHERE user_opin.user_id = :id;";
        $query = $conn->prepare($query);
        $query->bindparam(':id', $id);
        $query->execute();
        $query_results = $query->fetchAll();

        $length = count($query_results);

        for($i = 0; $i < $length; $i++)
        {
	    $opinion = $query_results[$i][0];

            $opinion = str_replace("_", " ", $opinion);

            $opinion = ucwords($opinion);

            echo        "<div class='form-group' style='margin:20px'><div class='links-opinions col-xs-7' style='display:inline-block; font-weight:600'>"
                        . $opinion .
                        "</a></div>";

	    $choice = "choice" . $i;

            if($query_results[$i][1] == 'f')
            {
	     echo "<div style='display:inline-block;'>".
                "<label for='choice1'> Opinion: </label>".
                "<select class='selectpicker' name=$choice>".
                "   <option selected value='0'>For</option>".
                "   <option value='1'>Against</option>".
                "   <option value='2'>Neutral</option>".
                "</select>".
                "</div></div>"; 
            }
            else if($query_results[$i][1] == 'a')
            {
                echo "<div style='display:inline-block;'>".
                "<label for='choice1'> Opinion: </label>".
                "<select class='selectpicker' name=$choice>".
                "   <option value='0'>For</option>".
                "   <option selected value='1'>Against</option>".
                "   <option value='2'>Neutral</option>".
                "</select>".
                "</div></div>";
            }
            else
            {         
                echo "<div style='display:inline-block;'>".
                    "<label for='choice1'> Opinion: </label>".
                    "<select class='selectpicker' name=$choice>".
                    "   <option value='0'>For</option>".
                    "   <option value='1'>Against</option>".
                    "   <option selected value='2'>Neutral</option>".
                    "</select></div></div>";
            }
        }
    }

    function get_info($conn, $id)
    {
	$query = "
		SELECT state, county, city
		, first, last, username, password, age, email, gender
		from users
		where id = :id
		";
	$query = $conn->prepare($query);
	$query->bindparam(':id', $id);
	$query->execute();

	$results = $query->fetchAll();

	$stateID = $results[0][0];
	$countyID = $results[0][1];
	$cityID = $results[0][2];

	$firstname = $results[0][3];
	$lastname = $results[0][4];
	$username = $results[0][5];
	$password = $results[0][6];
	$age = $results[0][7];
	$email = $results[0][8];
	$gender = $results[0][9];

	     echo "<div class='col-sm-6'><div class='background'><div class='form-group form-inline'><label for='firstname'> First Name: </label>".
		" <input id='firstname' class='form-control'  align='right' value=$firstname type='text' name='firstname' required='required'>".
                "</div>";

	     echo "<div class='form-group form-inline'><label for='lastname'> Last Name: </label>".
		" <input id='lastname' class='form-control' align='right'  value=$lastname type='text' name='lastname' required='required'>".
                "</div>";

	     echo "<div class='form-group form-inline'><label for='username'> Username: </label>".
		" <input id='username' class='form-control' align='right' value=$username type='text' name='username' required='required'>".
                "</div>";

	     echo "<div class='form-group form-inline'><label for='password'> Password: </label>".
		" <input id='password' class='form-control' value=$password type='password' name='password' required='required'>".
                "</div>";

	     echo "<div class='form-group form-inline'><label for='email'> Email: </label>".
		" <input id='email' class='form-control' align='right'  value=$email type='email' name='email' required='required'>".
                "</div>";

	     echo "<div class='form-group form-inline'><label for='age'> Age: </label>".
		" <input id='age' class='form-control' align='right' value=$age type='number' name='age' required='required'>".
                "</div>";

		if($gender=="m")
		     echo "<div class='form-group form-inline'>".
                	"<label for='gender'> Male: </label>".
			" <input id='gender' checked='checked' value='m' type='radio' name='gender' required='required'>".
			"&nbsp". "&nbsp". "&nbsp". "&nbsp". "&nbsp".
	                "<label for='gender'> Female: </label>".
			" <input id='gender' value='f' type='radio' name='gender' required='required'>".
	                "</div>";
		else
		     echo "<div class='form-group form-inline'><label for='gender'> Male: </label>".
			" <input id='gender' value='m' type='radio' name='gender' required='required'>".
			"&nbsp". "&nbsp". "&nbsp". "&nbsp". "&nbsp".
	                "<label for='gender'> Female: </label>".
			" <input id='gender' checked='checked' value='f' type='radio' name='gender' required='required'>".
	                "</div>"; 

	// Start of getting the user's state, county, city
	$user_id = $_GET['id'];

	include 'scripts/web_scripts/get_connection.php'; 

	$query = "
		SELECT state, county, city
		from users
		where id = :user_id
		";
	$query = $conn->prepare($query);
	$query->bindparam(':user_id', $user_id);
	$query->execute();

	$results = $query->fetchAll();

	$state = $results[0][0];
	$county = $results[0][1];
	$city = $results[0][2];

	$query = $conn->prepare("SELECT name FROM states where id = :state;");
	$query->bindparam(':state', $state);
	$query->execute();
	$result = $query->fetchAll();
	$stateName = ucwords($result[0]['name']);

	$query = $conn->prepare("SELECT name FROM counties where id = :county;");
	$query->bindparam(':county', $county);
	$query->execute();
	$result = $query->fetchAll();
	$countyName = str_replace("_", " ", $result[0]['name']);
	$countyName = ucwords($countyName );

	$query = $conn->prepare("SELECT name FROM cities where id = :city");
	$query->bindparam(':city', $city);
	$query->execute();
	$result = $query->fetchAll();
	$cityName = str_replace("_", " ", $result[0]['name']);
	$cityName = ucwords($cityName);
 ?>

    	        <script type="text/javascript">
					$(document).ready(function(){
						$("#dropdownMenu").change(function(){
						document.getElementById("dropdownMenu2").innerHTML = ""; 
						$("#dropdownMenu2").append("<option selected>Select a County</option>"); 
						populateCounties(this.value); 

						$("#dropdownCounties").show();
					});
					$("#dropdownMenu2").change(function(){
						document.getElementById("dropdownMenu3").innerHTML = ""; 
						$("#dropdownMenu3").append("<option selected>Select a City</option>"); 
						var x = document.getElementById("dropdownMenu2");
						var value = x.options[x.selectedIndex].value;
						populateCities(value);

						$("#dropdownCities").show();  
					});

					populateStates(); 
					populateCounties("<?php echo $stateName; ?>"); 
					populateCities("<?php echo $county; ?>"); 
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
						$("#dropdownMenu option[value=<?php echo $stateName; ?>]").attr("selected","selected");
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
						$("#dropdownMenu2 option[value=<?php echo $county; ?>]").attr("selected","selected");
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
						$("#dropdownMenu3 option[value='<?php echo $cityName; ?>']").attr("selected","selected");
					    }
				    }
				    xmlhttp.open("GET", "/scripts/web_scripts/get_cities_register.php?county_id=" + countyid, true); 
				    xmlhttp.send(); 
				}

			</script>

 	<div class="dropdown seconditems">
		<div class='form-group form-inline'>
		<label for='state'> State: </label>
 		<select class="dropdown-toggle selectpicker" type="button" id="dropdownMenu" name="dropdownMenu" data-toggle="dropdown" aria-expanded="true">
			<option selected>State ...</option>
 		</select>
		</div>
 	</div>
 	<div class="dropdown" id="dropdownCounties">
		<div class='form-group form-inline'>
		<label for='state'> County: </label>
 		<select class="dropdown-toggle selectpicker" type="button" id="dropdownMenu2" name="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
 			<option selected>Select State ...</option>
 		</select>
		</div>
 	</div>
 	<div class="dropdown" id="dropdownCities">
		<div class='form-group form-inline'>
		<label for='state'> City: </label>
 		<select class="dropdown-toggle selectpicker" type="button" id="dropdownMenu3" name="dropdownMenu3" data-toggle="dropdown" aria-expanded="true">
 			<option selected>Select County ...</option>
 		</select>
		</div>
 	</div></div></div>
 	<!-- Start the opinions -->
 	<div class='col-sm-6'><div class='background'>

<?php
    }
?>

				</div></div>
				</div>
				<div class="row" style="text-align: center; margin-top: 450px;">
	  				<input type="submit" class="btn-success btn-default btn" value="Update"/> 
				</div>
			</div>
		</form>
	</div>
		<span id="footerSection"></span>
	</body>
</html>