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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Latest compiled and minified JavaScript -->
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
  
  #top
  {
    background: url(pic/browndesk.jpg) no-repeat center center;
    background-size: 100% 100%; 
    height: 600px; 
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
			<div align="center">





	
		














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
		set_opinions($conn, $id);
	}


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
echo "Undecided";
            	}
	}
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
                "   <option value='2'>Undecided</option>".
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
                "   <option value='2'>Undecided</option>".
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
                    "   <option selected value='2'>Undecided</option>".
                    "</select>".
                    "</p>".
                    "</br>";
            }
        }
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



