<?php

include '../scripts/web_scripts/get_connection.php';

$poll_id = $_GET['poll_id'];

$poll_question = "start";

$query = "SELECT question FROM polls where id = :poll_id;";

$query = $conn->prepare($query);
$query->bindparam(':poll_id', $poll_id);
$query->execute();
$result = $query->fetchAll();

$poll_question = $result[0]['question'];

if( empty($_POST) ){
	?>
	<html>
		<head>
			<meta charset="utf-8" />
			<link rel="shortcut icon" href="http://10.171.204.135/pic/icon.ico">
			<title>Poll Question</title>
			<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			  <script src="/applications/js/html5shiv.min.js"></script>
			  <script src="/applications/js/respond.min.js"></script>
			<![endif]-->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
			<script type="text/javascript" src="http://10.171.204.135/js/main.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			<link href="http://10.171.204.135/css/pe-icon-7-stroke.css" rel="stylesheet" />
			<link href="http://10.171.204.135/css/ct-navbar.css" rel="stylesheet" />
			<link href="http://10.171.204.135/css/main.css" rel="stylesheet" />
			<link href="http://10.171.204.135/css/replies.css" rel="stylesheet" />
			<style type="text/css">
			h3
			{
				text-align: center; 
				margin-top: 50px; 
				color: #005e7e;
				margin-bottom: 10px; 
			}
			.your-reply:last-child
			{
				margin: 20px; 
			}
			.your-reply
			{
				background: #F2F1F1;
				padding: 20px;
				border-radius: 5px; 
			}
			form
			{
				border-spacing: 0; 
				border-collapse: collapse;
				border-style: none; 
				border-width: 0; 
			}

			.center
			{
				text-align: center; 
			}
			.submitButton
			{
				margin: auto !important;
				display: block !important; 
				background-color: #5cb75c;
				color: white;
				font-size: medium;
				padding:5px 10px;
				border-color: #5cb75c;
			}
			#submitReponse
			{
				float: right; 
				margin-right: 12px; 
				color: white; 
				background-color: #3cb1cb; 
				padding: 10px;
			}
			.error
			{
				border-color: red !important; 
			}
			</style>
			<script type="text/javascript">
			var topic_id; 
			var user_id; 
			$(document).ready(function(){
				topic_id = getParameterByName("poll_id"); 
				retrieveForum(topic_id);
				getUser(); 
				updateViewCount(topic_id); 
				admin(); 
			}); 

		    function getParameterByName(name) 
		    {
		      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		      results = regex.exec(location.search);
		      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		    }

			function deletepoll()
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
				  var url = 'http://10.171.204.135/scripts/web_scripts/delete_post_or_poll.php?poll_id='+ topic_id;
				  alert(url); 
				  xmlhttp.open("POST", url, true); 
				  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				  xmlhttp.send(url); 

				 setTimeout(function(){
				    alert("Poll Deleted"); 
				   	window.history.back();
				  }, 1000);	

			}

			function admin()
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
		    xmlhttp.onreadystatechange = function(){ 
		      if(xmlhttp.readyState==4 && xmlhttp.status==200)
		      {
		        var temp = xmlhttp.responseText;
		        if(temp == 'True')
		        {
		          $("#danger").show(); 
		        }
		      }
		    }
		    xmlhttp.open("GET", "http://10.171.204.135/scripts/web_scripts/test_admin.php?user_id=" + user_id, true); 
		    xmlhttp.send(); 
		  }

		    //The following function will find the name of the topic_id
		    function retrieveForum(topic_id)
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
		      xmlhttp.onreadystatechange = function(){ 
		        if(xmlhttp.readyState==4 && xmlhttp.status==200)
		        {
		            var temp = $.parseJSON(xmlhttp.responseText);

		            for(var i in temp)
		            {
		            	var attach = "<div class='post-reply'><div class='post-content clear'><div class='post-details'><div class='meta-info'><span class='author'>" + temp[i].username; 
		            	attach += "</span><span class='create_date'>" + temp[i].ts; 
		            	attach += "</span></div><div class='post-body'><div class='current-post-content'>" + temp[i].content; 
		            	attach += "</div></div><div class='inline-replies'></div></div></div>";
		            	$("#post-here").append(attach); 
		            }
		        }
		      }
		      xmlhttp.open("GET", "http://10.171.204.135/scripts/web_scripts/get_poll_replies.php?poll=" + topic_id, true); 
		      xmlhttp.send(); 
		    }

			function updateViewCount(topic_id)
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
			  var url = 'http://10.171.204.135/scripts/web_scripts/	update_poll_view_count.php?poll_id=' + topic_id;
			  xmlhttp.open("POST", url, true); 
			  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			  xmlhttp.send(url); 
			}
		    function postReply()
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
				  var url = 'http://10.171.204.135/scripts/web_scripts/insert_poll_reply.php?author='+ user_id + '&content=' + $("#multText").val() + '&poll=' + topic_id;
				  
				  xmlhttp.open("POST", url, true); 
				  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				  xmlhttp.send(url); 
				  setTimeout(function(){
				    window.location.reload(1);
				  }, 2000);	
		    }
		    function getUser()
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
				xmlhttp.onreadystatechange = function(){ 
				  if(xmlhttp.readyState==4 && xmlhttp.status==200)
				  {
				    var temp = xmlhttp.responseText; 
				    $("#userIDInput").val(temp); 
				    user_id = $("#userIDInput").val(); 
				    if(user_id == 'false')
				    {
				      $("#logout").hide();  
				      $("#profile").hide(); 
				    }
				    else
				    {
				     $("#login").hide();
				     var a = document.getElementById('profileLink'); 
				     a.setAttribute("href", "profile.php?id="+user_id); 
				    }
				  }
				}
				xmlhttp.open("GET", "/scripts/web_scripts/loginCheck.php", true);
				xmlhttp.send(); 
			}

			function checkValid()
		    {
		      var valid = true;
		      $("#loginError").hide(); 
		      $("#multText").removeClass("error");
		      if($("#multText").val() == "")
		      {
		        $("#multText").addClass("error"); 
		        valid = false; 
		      }
		      if(user_id == 'false')
		      {
		        valid = false; 
		        $("#loginError").show(); 
		      }
		      if(valid == true)
		      {
		        postReply(); 
		        //Clear Form
		        $("#multText").removeClass("error"); 
		        $("#multText").val("");
		        $("#loginError").hide(); 
		      }
		    }
			</script>
		</head>

		</html>
		<?php
			session_start();
			if(isset($_SESSION["user_id"])){



session_start();
$user_id = $_SESSION["user_id"];
$poll_id = $_GET['poll_id'];

$stmt = "
	SELECT user_id, poll_id, vote
	FROM poll_results
	where user_id = :user_id
	AND poll_id = :poll_id;";

$stmt = $conn->prepare($stmt);
$stmt->bindparam(':user_id', $user_id);
$stmt->bindparam(':poll_id', $poll_id);
$stmt->execute();

$results = $stmt->fetchall();

if(count($results) > 0){
				?>
				<html>

				<body>
				    <span id="navbarSection"></span>
					<div class="container" style="margin-top: 30px; margin-botom: 30px;">
						<button style="float:right; display:none" type="button" onclick="deletepoll()" id="danger" class="btn btn-danger">Delete Poll</button>
						<div style="margin: 40px auto">
							<form id='poll' action="Poll_Question.php?poll_id=<?php echo $poll_id;?>" method="post" accept-charset="utf-8">
								<h3> <?php echo "$poll_question";?> </h3>
								<div class="container" style="width: 20%">
									<input type="radio" name="answer" value="y" id="opt1" /><label for='Yes'>&nbsp;Yes</label><br />
									<input type="radio" name="answer" value="n" id="opt2" /><label for='No'>&nbsp;No</label><br />
									<input type="radio" name="answer" value="u" id="opt3" /><label for='Undecided'>&nbsp;Undecided</label><br /><br />
									<input type="submit" class="btn submitButton btn-default" value="Re-Vote" />
<?php echo "<br>"; ?>
									<input type="button" class="btn submitButton btn-default" value="View Results" onclick="location.href='http://10.171.204.135/PollResults/Poll_Results.php?poll_id=<?php echo $poll_id;?>';" />
								</div>
							</form>
						</div>
						<div class="col-md-12" id="post-here" style="margin-bottom: 20px;">
							<div class="reply-header clear">
								<h2>Responses</h2>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row clear your-reply thread-reply" style="margin-left: auto; margin-right: auto; width: 50%">
								<!-- This is where the users will put their reply --> 
								<div class="clear">
									<textarea id="multText" class="form-control" rows="7" placeholder="Add your response..."></textarea>
									<button type="submit" style="margin-top: 15px;" class="btn btn-default" id="submitReponse" onclick="checkValid()">Add your response</button>
								</div>
								<div id="success" style="display:none; color: green; text-align:center; font-size:medium; margin-top: 20px;">Topic has been Submitted!</div>
						      	<div id="loginError" style="display:none; color: green; text-align:center; font-size:medium; margin-top: 20px;">You need to be log-in to take part of the forums.</div>
							</div>
						</div>
					</div>
					<span id="footerSection"></span>
				</body>

				</html>
		<?php
}
else{
				?>
				<html>

				<body>
				    <span id="navbarSection"></span>
					<div class="container" style="margin-top: 30px; margin-botom: 30px;">
						<button style="float:right;  display:none" type="button" onclick="deletepoll()" id="danger" class="btn btn-danger">Delete Poll</button>
						<div style="margin: 40px auto">
							<form id='poll' action="Poll_Question.php?poll_id=<?php echo $poll_id;?>" method="post" accept-charset="utf-8">
								<h3> <?php echo "$poll_question";?> </h3>
								<div class="container" style="width: 20%">
									<input type="radio" name="answer" value="y" id="opt1" /><label for='Yes'>&nbsp;Yes</label><br />
									<input type="radio" name="answer" value="n" id="opt2" /><label for='No'>&nbsp;No</label><br />
									<input type="radio" name="answer" value="u" id="opt3" /><label for='Undecided'>&nbsp;Undecided</label><br /><br />
									<input type="submit" class="btn submitButton btn-default" value="Vote" />
								</div>
							</form>
						</div>
						<div class="col-md-12" id="post-here" style="margin-bottom: 20px;">
							<div class="reply-header clear">
								<h2>Responses</h2>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row clear your-reply thread-reply" style="margin-left: auto; margin-right: auto; width: 50%">
								<!-- This is where the users will put their reply --> 
								<div class="clear">
									<textarea id="multText" class="form-control" rows="7" placeholder="Add your response..."></textarea>
									<button type="submit" style="margin-top: 15px;" class="btn btn-default" id="submitReponse" onclick="checkValid()">Add your response</button>
								</div>
								<div id="success" style="display:none; color: green; text-align:center; font-size:medium; margin-top: 20px;">Topic has been Submitted!</div>
						      	<div id="loginError" style="display:none; color: green; text-align:center; font-size:medium; margin-top: 20px;">You need to be log-in to take part of the forums.</div>
							</div>
						</div>
					</div>
					<span id="footerSection"></span>
				</body>

				</html>
		<?php
}
			}
			else{
				?>
				<html>
		
				<body>
				    <span id="navbarSection"></span>
					<div class="container" style="margin-top: 30px; margin-botom: 30px;">
						<div style="margin: 40px auto">
							<form id='poll' action="Poll_Question.php?poll_id=<?php echo $poll_id;?>" method="post" accept-charset="utf-8">
								<h3> <?php echo "$poll_question";?> </h3>
								<div class="container" style="width: 20%">
									<input type="radio" name="answer" value="y" id="opt1" /><label for='Yes'>&nbsp;Yes</label><br />
									<input type="radio" name="answer" value="n" id="opt2" /><label for='No'>&nbsp;No</label><br />
									<input type="radio" name="answer" value="u" id="opt3" /><label for='Undecided'>&nbsp;Undecided</label><br /><br />
									<input type="button" class="btn submitButton btn-default" value="Please login to vote" />
								</div>
							</form>
						</div>
						<div class="col-md-12" id="post-here" style="margin-bottom: 20px;">
							<div class="reply-header clear">
								<h2>Responses</h2>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row clear your-reply thread-reply" style="margin-left: auto; margin-right: auto; width: 50%">
								<!-- This is where the users will put their reply --> 
								<div class="clear">
									<textarea id="multText" class="form-control" rows="7" placeholder="Add your response..." disabled></textarea>
									<button style="margin-top: 15px;" class="btn btn-default" id="submitReponse">Please login to vote</button>
								</div>
							</div>
						</div>
					</div>
					<input style="display:none" type="text" name="userID" id="userIDInput">
					<span id="footerSection"></span>
				</body>
		
		</html>
		<?php
			}
		?>
		<html>
		</html>
	<?php
}
else{
	session_start();
	$user_id = $_SESSION["user_id"];
	$poll_id = $_GET['poll_id'];
	$vote = $_POST['answer'];

	$stmt = "
		SELECT user_id, poll_id, vote
		FROM poll_results
		where user_id = :user_id
		AND poll_id = :poll_id;";

	$stmt = $conn->prepare($stmt);
	$stmt->bindparam(':user_id', $user_id);
	$stmt->bindparam(':poll_id', $poll_id);
	$stmt->execute();

	$results = $stmt->fetchall();

	if(count($results) > 0){

		$stmt = "
			DELETE
			FROM poll_results
			where user_id = :user_id
			AND poll_id = :poll_id;";
	
		$stmt = $conn->prepare($stmt);
		$stmt->bindparam(':user_id', $user_id);
		$stmt->bindparam(':poll_id', $poll_id);
		$stmt->execute();
	}

	$stmt = "
		INSERT INTO poll_results 
		(user_id, poll_id, vote) 
		VALUES (:user_id,:poll_id,:vote);";

	$stmt = $conn->prepare($stmt);
	$stmt->bindparam(':user_id', $user_id);
	$stmt->bindparam(':poll_id', $poll_id);
	$stmt->bindparam(':vote', $vote);

	$stmt->execute();

	header('Location: Poll_Results.php?poll_id=' . $poll_id);
}
?>

