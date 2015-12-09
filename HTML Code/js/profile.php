<html>
	<head>
		<title>My Profile</title>
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
  #developers
  {
    background: url(pic/developers.png);
    background-repeat: no-repeat;
    background-size: 100%; 
    font-weight: 600; 
    font-size: 36px; 
    color: white; 
    display: table;
    text-shadow: 1px 1px gray;
  }
  #feedbacklink
  {
    background: url(pic/notebook2.jpg);
    background-repeat: no-repeat;
    font-weight: 600; 
    font-size: 36px; 
    color: white; 
    display: table;
    text-shadow: 1px 1px gray;
  }

  h1
  {
    font-size: 34px; 
    letter-spacing: -1px; 
    font-weight: 300; 
    margin-top: 40px; 
    margin-bottom: 5px; 
    color: #9EC9CB; 
  }
  #form
  {
    margin-bottom: 20px; 
  }
  h2
  {
    display: block; 
    font-weight: 100; 
    font-size: 18px; 
    margin-bottom: 20px; 
    color: #A9A9A9; 
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

  <div class="row" id="top">
    <span id="navbarSection"></span>
    </div>
  </div>

		</br>
		<form name="myform" action="profile.php?id=<?php echo $_GET['id'];?>" method="POST">
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

/*
	$data = $form["firstname"];
echo "First" . $data;
	$data = $form["lastname"];
echo "Last" . $data;
	$data = $form["username"];
echo "user" . $data;
	$data = $form["password"];
echo "pass" . $data;
	$data = $form["email"];
echo "email" . $data;
	$data = $form["age"];
echo "age" . $data;
	$data = $form["gender"];
echo "gender" . $data;

	$data = $form["dropdownMenu"];
echo "State" . $data;
	$data = $form["dropdownMenu2"];
echo "County" . $data;
	$data = $form["dropdownMenu3"];
echo "City" . $data;
*/

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



//************* this needs to be finished *****************//
/*
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
	}
*/
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

            echo        "<div class='col-sm-4 links-opinions'>"
                        . $opinion .
                        "</a></div>";

	    $choice = "choice" . $i;

            if($query_results[$i][1] == 'f')
            {
	     echo "<p>".
                "<label for='choice1'> Opinion: </label>".
                "<select name=$choice>".
                "   <option selected value='0'>For</option>".
                "   <option value='1'>Against</option>".
                "   <option value='2'>Neutral</option>".
                "</select>".
                "</p>".
                "</br>";
            }
            else if($query_results[$i][1] == 'a')
            {
                echo "<p>".
                "<label for='choice1'> Opinion: </label>".
                "<select name=$choice>".
                "   <option value='0'>For</option>".
                "   <option selected value='1'>Against</option>".
                "   <option value='2'>Neutral</option>".
                "</select>".
                "</p>".
                "</br>";
            }
            else
            {         
                echo "<p>".
                    "<label for='choice1'> Opinion: </label>".
                    "<select name=$choice>".
                    "   <option value='0'>For</option>".
                    "   <option value='1'>Against</option>".
                    "   <option selected value='2'>Neutral</option>".
                    "</select>".
                    "</p>".
                    "</br>";
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

	     echo "<p>".
                "<label for='firstname'> First Name: </label>".
		" <input id='firstname' value=$firstname type='text' name='firstname' required='required'>".
                "</p>".
                "</br>";

	     echo "<p>".
                "<label for='lastname'> Last Name: </label>".
		" <input id='lastname' value=$lastname type='text' name='lastname' required='required'>".
                "</p>".
                "</br>";

	     echo "<p>".
                "<label for='username'> Username: </label>".
		" <input id='username' value=$username type='text' name='username' required='required'>".
                "</p>".
                "</br>";

	     echo "<p>".
                "<label for='password'> Password: </label>".
		" <input id='password' value=$password type='password' name='password' required='required'>".
                "</p>".
                "</br>";

	     echo "<p>".
                "<label for='email'> Email: </label>".
		" <input id='email' value=$email type='email' name='email' required='required'>".
                "</p>".
                "</br>";

	     echo "<p>".
                "<label for='age'> Age: </label>".
		" <input id='age' value=$age type='number' name='age' required='required'>".
                "</p>".
                "</br>";

		if($gender=="m")
		     echo "<p>".
                	"<label for='gender'> Male: </label>".
			" <input id='gender' checked='checked' value='m' type='radio' name='gender' required='required'>".
			"&nbsp". "&nbsp". "&nbsp". "&nbsp". "&nbsp".
	                "<label for='gender'> Female: </label>".
			" <input id='gender' value='f' type='radio' name='gender' required='required'>".
	                "</p>".
	                "</br>";
		else
		     echo "<p>".
                	"<label for='gender'> Male: </label>".
			" <input id='gender' value='m' type='radio' name='gender' required='required'>".
			"&nbsp". "&nbsp". "&nbsp". "&nbsp". "&nbsp".
	                "<label for='gender'> Female: </label>".
			" <input id='gender' checked='checked' value='f' type='radio' name='gender' required='required'>".
	                "</p>".
	                "</br>";

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
/*
echo $state;
echo $county;
echo $city;

echo $stateName;
echo $countyName;
echo "." . $cityName . ".";
*/

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
		<p>
		<label for='state'> State: </label>
 		<select class="dropdown-toggle" type="button" id="dropdownMenu" name="dropdownMenu" data-toggle="dropdown" aria-expanded="true">
			<option selected>State ...</option>
 		</select>
		</p>
 	</div>
 	<div class="dropdown" id="dropdownCounties">
		<p>
		<label for='state'> County: </label>
 		<select class="dropdown-toggle" type="button" id="dropdownMenu2" name="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
 			<option selected>Select State ...</option>
 		</select>
		</p>
 	</div>
 	<div class="dropdown" id="dropdownCities">
		<p>
		<label for='state'> City: </label>
 		<select class="dropdown-toggle" type="button" id="dropdownMenu3" name="dropdownMenu3" data-toggle="dropdown" aria-expanded="true">
 			<option selected>Select County ...</option>
 		</select>
		</p>
 	</div>

<?php
    }
?>

				<p class="button"> 
		  			<input type="submit" value="Update"/> 
				</p>
			</div>
		</form>

		</br>
		<span id="footerSection"></span>
	</body>
</html>



