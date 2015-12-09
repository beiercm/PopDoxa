var navbar = '<nav class="navbar navbar-transparent" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand navbar-brand-logo" href="http://10.171.204.135/home.html" style="margin-top: 1em"><div class="brand"> PopDoxa </div></a></div><div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"><ul class="nav navbar-nav navbar-right"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-search"></i><p>Search</p></a><ul class="dropdown-menu" id="dropdownitems" style="min-width: 300px"><li><div class="input-group"><form><input type="text" class="form-control" id="searchfield" style="width:190px" placeholder="Search for..." /></form><span class="input-group-btn"><button class="btn btn-default btn-success" type="button" id="searchbtn" onclick="searchsite()">Search</button></span></div></li></ul></li><li><a href="http://10.171.204.135/polls.html"><i class="pe-7s-graph"></i><p>Polls</p></a></li><li><a href="http://10.171.204.135/forum.html"><i class="pe-7s-pen"></i><p>Forums</p></a></li><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-user"></i><p>Login/Register</p></a><ul class="dropdown-menu"><li><a href="http://10.171.204.135/login.php">Login</a></li><li><a href="http://10.171.204.135/register.php">Register</a></li></ul></li></ul></div></div></nav><nav class="navbar navbar-default navbar-fixed-top" style="display:none; background-color:#252425;" id="fixed-nav"><div class="container" style="text-align:center; margin-top: 7px; font-size:x-large;"><a style="color: white;" href="http://10.171.204.135/home.html">PopDoxa</a></div></nav>'; 

var navbar1 = '<nav class="navbar navbar-transparent" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand navbar-brand-logo" href="http://10.171.204.135/home.html" style="margin-top: 1em"><div class="brand"> PopDoxa </div></a></div><div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"><ul class="nav navbar-nav navbar-right"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-search"></i><p>Search</p></a><ul class="dropdown-menu" id="dropdownitems" style="min-width: 300px"><li><div class="input-group"><form><input type="text" class="form-control" id="searchfield" style="width:190px" placeholder="Search for..." /></form><span class="input-group-btn"><button class="btn btn-default btn-success" type="button" id="searchbtn" onclick="searchsite()">Search</button></span></div></li></ul></li><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-graph"></i><p>Polls</p></a><ul class="dropdown-menu"><li><a id="stateHref1">State</a></li><li><a id="countyHref1">County</a></li><li><a id="cityHref1">City</a></li></ul></li><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-pen"></i><p>Forums</p></a><ul class="dropdown-menu"><li><a id="stateHref">State</a></li><li><a id="countyHref">County</a></li><li><a id="cityHref">City</a></li></ul></li><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-user"></i><p>Account</p></a><ul class="dropdown-menu"><li id="profile"><a id="profileLink">View Profile</a></li><li style="display:none;" id="adminPage"><a href="http://10.171.204.135/admin.html">Admin Page</a></li><li id="logout"><a href="http://10.171.204.135/logout.php">Log Out</a></li></ul></li></ul></div></div></nav><nav class="navbar navbar-default navbar-fixed-top" style="display:none; background-color: #252425;" id="fixed-nav"><div class="container" style="text-align:center; margin-top: 7px; font-size: x-large;"><a href="http://10.171.204.135/home.html" style="color: white">PopDoxa</a></div></nav>'; 

var privacyPolicy = '<h3 style="text-align: center;">Privacy Policy</h3><p align="justify">This Privacy Policy governs the manner in which PopDoxa collects, uses, maintains and discloses information collected from users (each, a "User") of the http://www.popdoxa.com website ("Site").</p><h3 style="text-align: center;">Personal identification information</h3><p align="justify">We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p><h3 style="text-align: center;">Non-personal identification information</h3><p align="justify">We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service provider’s utilized and other similar information.</p><h3 style="text-align: center;">Web browser cookies</h3><p align="justify">Our Site may use "cookies" to enhance User experience. User s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p><h3 style="text-align: center;">How we use collected information</h3><p align="justify">PopDoxa may collect and use Users personal information for the following purposes:<ul><li>To run and operate our Site<br />We may need your information display content on the Site correctly.</li><li>To personalize user experience<br />We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</li><li>To improve our Site<br />We may use feedback you provide to improve our products and services.</li><li>To send periodic emails<br />We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests.</li></ul></p><h3 style="text-align: center;">How we protect your information</h3><p align="justify">We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.</p><h3 style="text-align: center;">Sharing your personal information</h3><p align="justify">We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above. </p><h3 style="text-align: center;">Third party websites</h3><p align="justify">Users may find advertising or other content on our Site that link to the sites and services of our partners, suppliers, advertisers, sponsors, licensors and other third parties. We do not control the content or links that appear on these sites and are not responsible for the practices employed by websites linked to or from our Site. In addition, these sites or services, including their content and links, may be constantly changing. These sites and services may have their own privacy policies and customer service policies. Browsing and interaction on any other website, including websites which have a link to our Site, is subject to that website s own terms and policies.</p><h3 style="text-align: center;">Changes to this privacy policy</h3><p align="justify">PopDoxa has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p><h3 style="text-align: center;">Your acceptance of these terms</h3><p align="justify">By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes. Privacy policy created by GeneratePrivacyPolicy.com</p><h3 style="text-align: center;">Contacting us</h3><p align="justify">If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us by leaving submitting your comments or concerns in the Feedback page.</p><strong>This document was last updated on April 23, 2015</strong>'; 

var termsOfUse = '<h3 style="text-align: center;">Terms of Use</h3><p align="justify">Not only is Privacy Policy important to include in a site, but also Terms of Use documentation as well. As mentioned previously, if the project was given to a business, the privacy policy and Terms of Use will be able to protect the business online. Based on our research, we have come to find that these documents will actually improve the search engine optimization (SEO). SEO is known as the process of making a website or web page visible in a search engine’s unpaid outcomes. Therefore, most search engines, such as Google, ranks their trusted and quality sites higher in the results, if such documents exist. </p><p align="justify">Terms of Use depicts the rules a user should agree in order to use the given services. Some data that can be part of this agreement are as follows but not limited to:</p><ul><li>Intellectual property</li><li>How one should behave in PopDoxa’s online community</li><li>How we will handle complaints</li></ul><p align="justify">At times Terms of Use is also known as Terms and Conditions, Ts & Cs, or even Terms of Service. Therefore, based on the research that was conducted about what to include in Terms of Use, the words indented below is what will be placed in our site as the Terms of Use. Note, we did use a template (and customized it) to help us give a better guide on creating such a document.</p><p align="justify">Please read these Terms and Conditions (“Terms”, “Terms and Conditions”) carefully before using PopDoxa website or mobile application operated by Group 6 Senior Design Team. </p><p align="justify">Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. This applies for all visitors, users, and anyone else who is accessing and using PopDoxa. </p><p align="justify">By accessing or using the site, you agree to be bounded by these Terms. If you disagree with any part of the terms you may not access PopDoxa. </p><h3 style="text-align: center;">Prohibitions</h3><p align="justify">No one should misuse this site. You cannot commit or encourage a criminal offense, transmit something technologically harmful (such as virus, Trojan, worm, and logic bomb), hack into PopDoxa, corrupt data, cause a disturbance to other users, and post advertising or promotional material. </p><h3 style="text-align: center;">Intellectual Property, Software and Content</h3><p align="justify">The intellectual property rights in all software and content made available to you through PopDoxa remains the property of us. You may store, print and display the content for your own personal use. You are not permitted to publish, manipulate, distribute, or otherwise reproduce, in any format, any of the content or copies of the content supplied to you or which appears on this Website nor may you use any such content in connection with any business or commercial enterprise. </p><h3 style="text-align: center;">Termination</h3><p align="justify">We may terminate or suspend access to PopDoxa immediately for any reason. However, if you abide to all the terms and policies given to you, you would not be terminated.  </p><h3 style="text-align: center;">Changes to this Terms and Conditions</h3><p align="justify">PopDoxa has the discretion to update these terms at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about any recent changes. You acknowledge and agree that it is your responsibility to review these terms periodically and become aware of modifications.</p><h3 style="text-align: center;">Contacting us</h3><p align="justify">If you have any questions about our Terms and Conditions, the practices of this site, or your dealings with this site, please contact us by leaving submitting your comments or concerns in the Feedback page.</p><strong>This document was last updated on April 23, 2015</strong>'; 

var footer = '<input style="display:none" type="text" name="userID" id="userIDInput"><div id="footer"><div class="container"><div class="row col-lg-12 col-md-12" id="bottom-menu"><ul><li><a href="http://10.171.204.135/developers.html" class="individual">About Us</a></li><li><a data-toggle="modal" href="#mymodal" class="individual">Privacy Policy</a></li><li><a data-toggle="modal" href="#mymodal1" class="individual">Terms Of Use</a></li></ul></div></div></div><div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="mymodal" aria-hidden="true" id="mymodal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header" style="border-bottom: none;"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"></h4></div><div class="modal-body"><div>' + privacyPolicy + '</div></div></div></div></div><div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="mymodal1" aria-hidden="true" id="mymodal1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header" style="border-bottom: none;"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div>' + termsOfUse + '</div></div></div>';

var user_id; //retrieve the user's id --- if signed in
var state_id, county_id, city_id; 
var rounds = 0; 
$(document).ready(function(){
	$("#footerSection").after(footer); 
	//lastLogin();
  getUserID();
  $(window).scroll(function() {
      if ($(window).scrollTop() > 100) 
      {
        $("#fixed-nav").show(); // > 100px from top - show div
      }
      else 
      {
        $('#fixed-nav').hide();// <= 100px from top - hide div
      }
  });

  $('#searchfield').change( function() {
    alert("here"); 
      if(event.keyCode == 13) {
          searchsite();
          return false;
      }
  }); 

}); 

  function searchsite()
  {   
    if ($("#searchfield").val() != "")
    {
      window.location = "http://10.171.204.135/search.html?search=" + $("#searchfield").val() ;
    }
  }

function lastLogin()
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
      var url = '/scripts/web_scripts/update_last_login.php?user_id=1';
      xmlhttp.open("POST", url, true); 
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.send(url); 
}

  function isAdmin()
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
          $("#adminPage").show(); 
        }
      }
    }
    xmlhttp.open("GET", "/scripts/web_scripts/test_admin.php?user_id=" + user_id, true); 
    xmlhttp.send(); 
  }


function getUserID()
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
    if(xmlhttp.readyState==4 && xmlhttp.status==200 && rounds == 0)
    {
      var temp = xmlhttp.responseText; 
      $("#userIDInput").val(temp); 
      user_id = $("#userIDInput").val(); 
      if(user_id == 'false')
      {
        $("#navbarSection").after(navbar); 
      }
      else
      {

        $("#navbarSection").after(navbar1); 

        user_id = $("#userIDInput").val().split("/")[0]; 
        state_id = $("#userIDInput").val().split("/")[1]; 
        county_id = $("#userIDInput").val().split("/")[2]; 
        city_id = $("#userIDInput").val().split("/")[3]; 
      
       document.getElementById('profileLink').setAttribute("href", "http://10.171.204.135/profile.php?id="+user_id);
       document.getElementById('stateHref').setAttribute("href", "http://10.171.204.135/state.html?topic="+state_id);
       document.getElementById('countyHref').setAttribute("href", "http://10.171.204.135/county.html?topic="+county_id); 
       document.getElementById('cityHref').setAttribute("href", "http://10.171.204.135/city.html?topic="+city_id);
       document.getElementById('stateHref1').setAttribute("href", "http://10.171.204.135/state-polls.html?topic="+state_id);
       document.getElementById('countyHref1').setAttribute("href", "http://10.171.204.135/county-polls.html?topic="+county_id); 
       document.getElementById('cityHref1').setAttribute("href", "http://10.171.204.135/city-polls.html?topic="+city_id);
       getName('stateHref1', 'stateHref', "http://10.171.204.135/scripts/web_scripts/get_location_name.php?state="+state_id); 
       getName('countyHref1','countyHref', "http://10.171.204.135/scripts/web_scripts/get_location_name.php?county="+county_id); 
       getName('cityHref1', 'cityHref', "http://10.171.204.135/scripts/web_scripts/get_location_name.php?city="+city_id); 
       isAdmin();  
      }
      rounds++; 
    }
  }
  xmlhttp.open("GET", "/scripts/web_scripts/loginCheck.php", true);
  xmlhttp.send(); 
}



//The following function will parse the url and search for a specific name
function getParameterByName(name) 
{
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function capitalizeFirstLetter(string) 
{
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function getName(poll, forum, url)
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
      var topic = capitalizeFirstLetter(xmlhttp.responseText).replace("_", " ");
      document.getElementById(poll).innerHTML = topic;
      document.getElementById(forum).innerHTML = topic; 
    }
  }
  xmlhttp.open("GET", url, true); 
  xmlhttp.send(); 
}