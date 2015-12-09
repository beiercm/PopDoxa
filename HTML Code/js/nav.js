var topic_array = ["Reset passwords", "Hardware", "Mobile Devices", "Applications", "Network Connectivity", "IT Purchasing"]; //this is an array of the topics 
	var id_title=["reset", "hardware", "smart_phones","applications","connected","submit"]; //ids for the dropdown menus
	var topic_0 =[]; 
	var topic_1 =[]; 
	var	topic_2 =[]; 
	var topic_3 =[]; 
	var topic_4 =[]; 
	var topic_5 =[]; 
	
	function searchsite()
	{		
		if ($("#searchfield").val() != "")
		{
			window.location = "http://bbassi.sharepoint.com/help/search.aspx?topic=" + $("#searchfield").val() ;;
		}
	}

	$(document).ready(function() {	
		//$("#itpwalink").hide();	
		//CheckPermissions();	
		$('#searchfield').on('keydown', function(event) {
	        if(event.keyCode == 13) {
	            searchsite();
	            return false;
	        }
	    });
	   
		$('button.program').click(function(event) {
			$('#dropdownitems').toggle(); 
		});	
		
	});
	
	//------------------------JavaScript/JQuery for the Nav bar--------------------------------------------------------

	function getNavBarList()
	{    
		var clientContext = new SP.ClientContext.get_current();
		    var oList = clientContext.get_web().get_lists().getByTitle('Sub Topics');
		    var camlQuery = new SP.CamlQuery();
		    camlQuery.set_viewXml('<View><Query><Where><Eq><FieldRef Name="Status" /><Value Type="Choice">Active</Value></Eq></Where><OrderBy><FieldRef Name="Title" Ascending="True" /></OrderBy></Query></View>');   
		    this.collListItem = oList.getItems(camlQuery);
		       
		    clientContext.load(collListItem);    
		    clientContext.executeQueryAsync(Function.createDelegate(this, this.onSuccessList), Function.createDelegate(this, this.onQueryFailed));
	}
	
	function newTab(url)
	{
		window.open(
		  '' + url + '',
		  '_blank' // <- This is what makes it open in a new window.
		);
		
	}//end of goToURL function

	function onSuccessList(sender, args) 
	{	
 		var listItemInfo = '';
		var listItemEnumerator = collListItem.getEnumerator();
		while (listItemEnumerator.moveNext()) 
	    {
	       	var oListItem = listItemEnumerator.get_current();
	       	var title = oListItem.get_item("Title"); 
	       	if(title != 'How to Contact IT for Support')
	      	{
				var businessUnit = ""; 
				if(oListItem.get_item("BuisnessUnit") != null)
				{
					businessUnit += "<br /><span class='smallSub'>"; 
					for(var i = 0; i < oListItem.get_item("BuisnessUnit").length; i++)
					{
						if(i == (oListItem.get_item("BuisnessUnit").length - 1))
							businessUnit += oListItem.get_item("BuisnessUnit")[i].get_lookupValue(); 
						else
							businessUnit += oListItem.get_item("BuisnessUnit")[i].get_lookupValue() + ", "; 
					}

					businessUnit += "</span>"; 	
				}      	
	      	 	var current_topic = oListItem.get_item("Topic").get_lookupValue();
	      	 	var redirect = "none"; 
	      	 	if (oListItem.get_item("Redirect")){
	      	 	var redirect= oListItem.get_item("Redirect_x0020_Link").get_url(); 
				
				}
			
				if(current_topic == topic_array[0]){
					addToArray(topic_0, title, redirect, businessUnit); 
							
				}else if (current_topic == topic_array[1]){
					addToArray(topic_1, title, redirect, businessUnit); 
				
				}else if (current_topic == topic_array[2]){
					addToArray(topic_2, title, redirect, businessUnit); 
				
				}else if (current_topic == topic_array[3]){
					addToArray(topic_3, title, redirect, businessUnit); 
				
				}else if (current_topic == topic_array[4]){
					addToArray(topic_4, title, redirect, businessUnit); 
				
				}else{
					addToArray(topic_5, title, redirect, businessUnit); 
				}
			}
		}  //end of while loop 
	
		var iter=0; 
		
		while(iter < id_title.length){
			if(iter == 0){
				populate_NavBar(iter, topic_0);
			}else if (iter == 1){
				populate_NavBar(iter, topic_1);
			}else if (iter == 2){
				populate_NavBar(iter, topic_2);
			}else if (iter == 3){
				populate_NavBar(iter, topic_3);
			}else if (iter == 4){
				populate_NavBar(iter, topic_4);
			}else{
				populate_NavBar(iter, topic_5); 
			}
			iter++; 
		}//end of while statement
	
		
	}//end of onSuccessList function

	function addToArray(array, sub_topic, redirect, businessUnit){

		array.push(sub_topic + "|" + redirect + "|" + businessUnit);
	
	}

	function populate_NavBar(iter, arr){
		var temp = 0; //temp is used to make sure an empty row is not created on the menu option for the nar bar
	    var x=0; 
	   	    while (x < arr.length) 
	    {
    	   	if (temp != 0)
			{ //so it doesn't create an empty row
				$("#" + id_title[iter] + "").append("<li class='divider'></li>");
			}
			var businessUnit = arr[x].split("|")[2]; 
			if(arr[x].split("|")[1]  != "none"){
				$("#" + id_title[iter] + "").append("<li><a href='" + arr[x].split("|")[1] + "'>"  + arr[x].split("|")[0]  + businessUnit + "</a></li>");
			
			}else{
				var sub_topic = arr[x].split("|")[0]; 
				if(sub_topic.indexOf("&") !== -1){
					
					$("#" + id_title[iter] + "").append("<li><a href='subtopic.aspx?topic=" + sub_topic.split("&")[0] + "%26" + sub_topic.split("&")[1]  + "'>" + sub_topic + businessUnit + "</a></li>");

				}else{ 
					$("#" + id_title[iter] + "").append("<li><a href='subtopic.aspx?topic=" + sub_topic + "'>" + sub_topic + businessUnit + "</a></li>");
				}	 		
	 		}//end of else statement
	 		
	 		temp++;
	 		x++; 
	    }//end of while statement
		
 
	}//end of populate_NavBar function
	
	
	function getParameterByName(name) 
	{
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}//end of getParameterByName function
		
	
	
	function goToURL(url){
	
	location.href = ''+url+''; 
		
	}//end of goToURL function
	
	function CheckPermissions() {
	    var clientContext = new SP.ClientContext.get_current();	    
	    var collGroup = clientContext.get_web().get_siteGroups();
	    var oGroup = collGroup.getById(8878);
	    this.collUser = oGroup.get_users();
	    this.currentUser = clientContext.get_web().get_currentUser();	   	   
	    
        clientContext.load(currentUser);
	    clientContext.load(collUser);	
	    clientContext.executeQueryAsync(Function.createDelegate(this, this.onQuerySucceededUser), Function.createDelegate(this, this.onQueryFailed));
	}
	
	function onQuerySucceededUser() {
		var userInfo = '';
	
	    var userEnumerator = collUser.getEnumerator();
	    while (userEnumerator.moveNext()) {
	        var oUser = userEnumerator.get_current();
	        if (oUser.get_id() == currentUser.get_id()) {             
	        	$("#itpwalink").show();   
                break;
            }
	        //this.userInfo += '\nUser: ' + oUser.get_title() + '\nEmail: ' + oUser.get_email() + '\vLogin Name: ' + oUser.get_loginName();
	    }
	}
	
		