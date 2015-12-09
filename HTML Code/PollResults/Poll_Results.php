<?php 
	include '../scripts/web_scripts/get_connection.php';
	
	$poll_id = $_GET['poll_id'];
		
	$query = "SELECT question FROM polls where id = :poll_id;";
	
	$query = $conn->prepare($query);
	$query->bindparam(':poll_id', $poll_id);
	$query->execute();
	$result = $query->fetchAll();

	$poll_question = $result[0]['question'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Results</title> 

		<script type="text/javascript" src="amcharts.js"></script>
		<script type="text/javascript" src="pie.js"></script>
		<script type="text/javascript" src="serial.js"></script>
		<script type="text/javascript" src="themes/dark.js"></script>

		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

		<script type="text/javascript">



			AmCharts.loadJSON = function(url) {
				// create the request
				if (window.XMLHttpRequest) {
					// IE7+, Firefox, Chrome, Opera, Safari
					var request = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					var request = new ActiveXObject('Microsoft.XMLHTTP');
				}
	
				request.open('GET', url, false);
				request.send();
				return eval(request.responseText);
			};

			var poll_id = "<?php 

				try {
					if(PHP_SAPI === 'cli')
					{
						$poll_id = $argv[1];
					}
					else
					{
						$poll_id = $_GET['poll_id'];
					}
			
					}
				catch (PDOException $e)
				{
					echo "Connection failed: " . $e->getMessage();
					return;
				}

			echo $poll_id;

			?>"




$(document).ready(function(){ 

			AmCharts.loadJSON = function(url) {
				// create the request
				if (window.XMLHttpRequest) {
					// IE7+, Firefox, Chrome, Opera, Safari
					var request = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					var request = new ActiveXObject('Microsoft.XMLHTTP');
				}
	
				request.open('GET', url, false);
				request.send();
				return eval(request.responseText);
			};

	var chartData = AmCharts.loadJSON('/scripts/web_scripts/get_poll_results.php?poll_id=' + poll_id);
	
	$("#total").append("Total Voters: " + (parseInt(chartData[0]['votes'])+parseInt(chartData[1]['votes'])+parseInt(chartData[2]['votes'])));

}); 











			// all initial pie data
			var chartData = AmCharts.loadJSON('/scripts/web_scripts/get_poll_results.php?poll_id=' + poll_id);





//$("#total").append(parseInt(chartData[0]['votes'])+parseInt(chartData[1]['votes'])+parseInt(chartData[2]['votes']));





//$("#total").append("test");




			// all initial chart data
			var chartData2 = AmCharts.loadJSON('/scripts/web_scripts/get_opin_data.php?poll_id=' + poll_id);

			var chartData2_Yes = AmCharts.loadJSON('/scripts/web_scripts/get_yes_poll_results.php?poll_id=' + poll_id);

			var chartData2_No = AmCharts.loadJSON('/scripts/web_scripts/get_no_poll_results.php?poll_id=' + poll_id);

			var chartData2_Undecided = AmCharts.loadJSON('/scripts/web_scripts/get_undecided_poll_results.php?poll_id=' + poll_id);
		
			var graph0 = [{
				"balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
				"fillAlphas": 1,
				"labelText": "[[value]]",
				"lineAlpha": 0.3,
				"fontSize": 20,
				"title": "For",
				"id": "For",
				"type": "column",
				"color": "#FFFFFF",
				"valueField": "For"
			}];
		
			var graph1 = [{
				"balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
				"fillAlphas": 1,
				"labelText": "[[value]]",
				"lineAlpha": 0.3,
				"fontSize": 20,
				"title": "Against",
				"id": "Against",
				"type": "column",
				"color": "#FFFFFF",
				"valueField": "Against"
			}];

			var graph2 = [{
				"balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
				"fillAlphas": 1,
				"labelText": "[[value]]",
				"lineAlpha": 0.3,
				"fontSize": 20,
				"title": "Neutral",
				"id": "Neutral",
				"type": "column",
				"color": "#FFFFFF",
				"valueField": "Neutral"
			}];

			var graphs = graph0.concat(graph1);
			    graphs = graphs.concat(graph2);

		AmCharts.loadJSON = function(url) {
			// create the request
			if (window.XMLHttpRequest) {
				// IE7+, Firefox, Chrome, Opera, Safari
				var request = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				var request = new ActiveXObject('Microsoft.XMLHTTP');
			}
	
			request.open('GET', url, false);
			request.send();
			return eval(request.responseText);
		};

			// create pie chart	
			var chart = AmCharts.makeChart("chartdiv1", {
				"type": "pie",
//
				"dataProvider": chartData,
//"dataProvider": AmCharts.loadJSON('Pie_12_Data.php'),
// 11/4/15 commented the line above


// THIS WORKS								

				"valueField": "votes",
				"titleField": "vote",
				"labelText": "[[title]]: [[value]]",
				"pullOutOnlyOne": true,
				"theme": "dark",
				"fontSize": 20,
				"colors": ["#5DA5DA","#FAA43A","#60BD68"],
			});


			/*var chart;
			var legend;
			var selected;
	
//			var types = AmCharts.loadJSON('Pie_04_Data.php')

			// create pie chart	
			chart = new AmCharts.AmPieChart();
			chart.dataProvider = chartData;
			chart.titleField = "vote";
			chart.valueField = "votes";
			chart.fontSize = 20;
			chart.theme = "dark";
//			chart.labelText = "[[title]]: [[value]]";
//			chart.pullOutOnlyOne = "true";
//			chart.colors = ["#5DA5DA","#FAA43A","#60BD68"];

			chart.write("chartdiv1");*/

			var PollTitle = "<?php echo $poll_question;?>";

			// Add Title
			chart.addTitle(PollTitle,30,"#FFFFFF",1.0,1);

			var chart2 = AmCharts.makeChart("chartdiv2", {
				"type": "serial",
				"theme": "dark",
				"legend": {
					"horizontalGap": 10,
					"maxColumns": 1,
					"position": "right",
					"useGraphSettings": true,
					"markerSize": 10
				},
				"fontSize": 20,
				"colors": ["#5DA5DA","#FAA43A","#60BD68"],
				"dataProvider": chartData2,
				"valueAxes": [{
					"stackType": "regular",
					"axisAlpha": 0.3,
					"gridAlpha": 0
				}],
				"graphs": graphs,
				"categoryField": "category2",
				"categoryAxis": {
					"labelRotation": 0,
					"gridPosition": "start",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"position": "left"
				},
				"export": {
					"enabled": true
				 },
				"maxSelectedSeries": 4,
				"mouseWheelScrollEnabled": true,
				"chartScrollbar": {
				    "graphType": "column",
				    "resizeEnabled": false,
				    "scrollbarHeight": 21,
				    "scrollDuration": 0,
				    "updateOnReleaseOnly": true
				}
			});

			var chartScrollbar = new AmCharts.ChartScrollbar();
			chartScrollbar.resizeEnabled = false;
			chart2.addChartScrollbar(chartScrollbar);

			// Add Title
			chart2.addTitle("All Voters",30,"#FFFFFF",1.0,1);

			var t = 0;

			var temp2 = 0;
			var lastClicked = -1;
			var lastOver = -1;

			function validateData() {
				// check which slices are hidden
				var hiddenIndexes = [];
				for ( var x = 0; x < legend2.legendData.length; x++ ) {
					if ( legend2.legendData[ x ].hidden )
						hiddenIndexes.push( x );
				}
				chart.validateData();  
				// reapply hidden items
				for ( var x = 0; x < hiddenIndexes.length; x++ ) {
					chart.hideSlice( hiddenIndexes[ x ] );
				}
			}

			// Highlight slices and chart rows when hovering over pie
			chart.addListener("pullOutSlice", function (event) {

lastClicked = event.dataItem.index;

//alert("Roll Over Slice");
//alert("moving out");
//if(out == 0){
//alert("moving out1" + out);
//out = 1;
//alert("moving out2" + out);
				chart.titles = [];
				chart2.titles = [];
//				chart.pieAlpha = 0.1;
//				chart.alphaField = "alpha";
//				chart.dataProvider[0].alpha = 0.1;
//				chart.dataProvider[1].alpha = 0.1;
//				chart.dataProvider[2].alpha = 0.1;
				if(event.dataItem.index == 0){
					chart.addTitle("Yes",30,"#FFFFFF",1.0,1);
					chart2.addTitle("Yes Voters",30,"#FFFFFF",1.0,1);
					chart2.dataProvider = chartData2_Yes;
//					chart.dataProvider[0].alpha = 1;
//					chart2.graphs[1].fillAlphas = 0.1;
//					chart2.graphs[2].fillAlphas = 0.1;
				}
				if(event.dataItem.index == 1){
					chart.addTitle("No",30,"#FFFFFF",1.0,1);
					chart2.addTitle("No Voters",30,"#FFFFFF",1.0,1);
					chart2.dataProvider = chartData2_No;
//					chart.dataProvider[1].alpha = 1;
//					chart2.graphs[0].fillAlphas = 0.1;
//					chart2.graphs[2].fillAlphas = 0.1;
				}
				if(event.dataItem.index == 2){
					chart.addTitle("Undecided",30,"#FFFFFF",1.0,1);
					chart2.addTitle("Undecided Voters",30,"#FFFFFF",1.0,1);
					chart2.dataProvider = chartData2_Undecided;
//					chart.dataProvider[2].alpha = 1;
//					chart2.graphs[0].fillAlphas = 0.1;
//					chart2.graphs[1].fillAlphas = 0.1;
				}
				chart2start=chart2.start;
				chart2end=chart2.end;
				chart2.validateData();
				chart2.zoom(chart2start,chart2end);

//10/18/15 removed because not working with it
//11/5/15 Remove below to fix but pie doesnt pull out
//alert("here" + temp2)
				if(temp2==0){		
					
					temp2=1;
				}else{
//validateData();
					temp2=0;
				}
//}
			});

			chart.addListener("pullInSlice", function (event) {
				if(lastClicked == lastOver){
//alert("Roll Out Slice");
//alert("moving in");
//if(out==1){
//out = 0;
//}
					temp2=0;
//					chart.dataProvider[0].alpha = 1;
//					chart.dataProvider[1].alpha = 1;
//					chart.dataProvider[2].alpha = 1;
//					chart2.graphs[0].fillAlphas = 1;
//					chart2.graphs[1].fillAlphas = 1;
//					chart2.graphs[2].fillAlphas = 1;
					chart.titles = [];
					chart2.titles = [];
					chart.addTitle("Results",30,"#FFFFFF",1.0,1);
					chart2.addTitle("All Voters",30,"#FFFFFF",1.0,1);
					chart2.dataProvider = chartData2;
					chart2start=chart2.start;
					chart2end=chart2.end;
					chart2.validateData();
					chart2.zoom(chart2start,chart2end);
					chart2.animateAgain();
					validateData();
				}
			} );
			chart.addListener("rollOverSlice", function (event) {
				lastOver= event.dataItem.index;
			} );


			/*chart.addListener("rollOverSlice", function (event) {
//alert("Pull Out Slice");
				if(event.dataItem.index == 0){
					chart2.graphs = graph0;
					chart2.colors = ["#5DA5DA"];
				}
				if(event.dataItem.index == 1){
					chart2.graphs = graph1;
					chart2.colors = ["#FAA43A"];
				}
				if(event.dataItem.index == 2){
					chart2.graphs = graph2;
					chart2.colors = ["#60BD68"];
				}
				chart2.graphs[0].fillAlphas = 1;
				chart2start=chart2.start;
				chart2end=chart2.end;
				chart2.validateData();
				chart2.zoom(chart2start,chart2end);

				chart.titles = [];
				chart2.titles = [];
				chart.alphaField = "alpha";
				if(event.dataItem.index == 0){
					chart.addTitle("Yes",30,"#FFFFFF",1.0,1);
					chart2.addTitle("Yes",30,"#FFFFFF",1.0,1);
					chart.dataProvider[0].alpha = 1;
					chart2.graphs[3].fillAlphas = 1;
				}
				if(event.dataItem.index == 1){
					chart.addTitle("No",30,"#FFFFFF",1.0,1);
					chart2.addTitle("No",30,"#FFFFFF",1.0,1);
					chart.dataProvider[1].alpha = 1;
					chart2.graphs[3].fillAlphas = 1;
				}
				if(event.dataItem.index == 2){
					chart.addTitle("Undecided",30,"#FFFFFF",1.0,1);
					chart2.addTitle("Undecided",30,"#FFFFFF",1.0,1);
					chart.dataProvider[2].alpha = 1;
					chart2.graphs[3].fillAlphas = 1;
				}
			// You don't make it this far, error out on the [3].
			});

			chart.addListener("rollOutSlice", function (event) {
//alert("Pull In Slice");
				chart2.graphs = graphs;
				chart2.colors = ["#5DA5DA","#FAA43A","#60BD68"];
				chart2.graphs[0].fillAlphas = 1;
				chart2.graphs[1].fillAlphas = 1;
				chart2.graphs[2].fillAlphas = 1;
				chart2start=chart2.start;
				chart2end=chart2.end;
				chart2.validateData();
				chart2.zoom(chart2start,chart2end);
				validateData();
// maybe comment line above
			} );*/

			/*// Click pie piece when graph item is clicked
			chart2.addListener( "clickGraphItem", function( event ) {
//alert("clicked");
				if(event.graph.title == "Yes") {
					chart.clickSlice( 0 );
				}
				if(event.graph.title == "No") {
					chart.clickSlice( 1 );
				}
				if(event.graph.title == "Undecided") {
					chart.clickSlice( 2 );
				}	
			} );*/

			var temp = 0;

			// Roll over pie piece when graph item is rolled over
			chart2.addListener( "rollOverGraphItem", function( event ) {
//alert("Roll Over Graph");
				if(temp==0){
					chart.rollOverSlice( event.graph.index );
					temp=1;
				}
//alert("Roll Over Graph");
			} );

			chart2.addListener( "rollOutGraphItem", function( event ) {
//alert("Roll Out Graph")
				temp=0;
				chart.rollOutSlice( event.graph.index );
			} );/*

			// create legend
			var legend2 = new AmCharts.AmLegend();
			legend2.color = "#FFFFFF";
			legend2.align = "center";
			legend2.position = "bottom";
			legend2.markerType = "circle";
			legend2.rollOverGraphAlpha = 0.5;
			legend2.borderAlpha = 0.5;
			legend2.borderColor = "#FFFFFF";
			legend2.backgroundColor = "#706666";
			legend2.markerBorderThickness = 1;
			legend2.fontSize = 20;
			chart.addLegend(legend2);*/

			// create legend
			var legend = new AmCharts.AmLegend();
			legend.color = "#FFFFFF";
			legend.align = "center";
			legend.position = "bottom";
			legend.markerType = "circle";
			legend.rollOverGraphAlpha = 0.5;
			legend.borderAlpha = 0.5;
			legend.borderColor = "#FFFFFF";
			legend.backgroundColor = "#706666";
			legend.markerBorderThickness = 1;
			legend.fontSize = 20;
			chart2.addLegend(legend);
	
			/* Filter pie chart when clicking on legend
			legend.addListener('hideItem', function (event) {
				chart.hideSlice(event.dataItem.index);
				chart.pieAlpha = 1;
				chart.alphaField = "alpha";
				chart.dataProvider[0].alpha = 1;
				chart.dataProvider[1].alpha = 1;
				chart.dataProvider[2].alpha = 1;
				validateData();
			});
				
			legend.addListener('showItem', function (event) {
				chart.showSlice(event.dataItem.index);
			});

			// This does not work but stops the legend marker circle from only removing the chart
			legend.addListener( "rollOverMarker", function( event ) {
				chart2.graphs[0].fillAlphas = 1;
				chart2.graphs[1].fillAlphas = 1;
				chart2.graphs[2].fillAlphas = 1;
				chart2.validateData();
				chart2.animateAgain();
			} );

			// pie chart when hovering over legend
			legend.addListener( "rollOverItem", function( event ) {
				chart.pieAlpha = 1;
				chart.alphaField = "alpha";
				chart.dataProvider[0].alpha = 0.5;
				chart.dataProvider[1].alpha = 0.5;
				chart.dataProvider[2].alpha = 0.5;
				if(event.dataItem.index == 0){
					chart.dataProvider[0].alpha = 1;
				}
				if(event.dataItem.index == 1){
					chart.dataProvider[1].alpha = 1;
				}
				if(event.dataItem.index == 2){
					chart.dataProvider[2].alpha = 1;
				}
				validateData();
			} );
			
			legend.addListener( "rollOutItem", function( event ) {
				chart.dataProvider[0].alpha = 1;
				chart.dataProvider[1].alpha = 1;
				chart.dataProvider[2].alpha = 1;
				chart2.graphs[0].fillAlphas = 1;
				chart2.graphs[1].fillAlphas = 1;
				chart2.graphs[2].fillAlphas = 1;
				chart.titles = [];
				chart2.titles = [];
				chart.addTitle("Results",30,"#FFFFFF",1.0,1);
				chart2.addTitle("Affiliations",30,"#FFFFFF",1.0,1);
				validateData();
				chart2.validateData();
			} );*/
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link href="http://10.171.204.135/css/pe-icon-7-stroke.css" rel="stylesheet" />
		<link href="http://10.171.204.135/css/ct-navbar.css" rel="stylesheet" />
	  	<script src="http://10.171.204.135/js/main.js"></script>
	  	<link href="http://10.171.204.135/css/main.css" rel="stylesheet" />
	</head>
	<body style="background-color: #706e6e;">
		<span id="navbarSection"></span>
		<div class="container" style="margin-bottom: 50px;">
			<div style="margin: 40px 0;">
				<div id="chartdiv1" style="width: 50%; height: 500px; background-color: #706e6e; font-size: 11px; float: left;" ></div>
				<div id="chartdiv2" style="width: 50%; height: 500px; background-color: #706e6e; font-size: 11px; float: left; padding-bottom:50px; margin-bottom-50px;" ></div>
<div id="total" style="color: #DDDDDD; font-size: 20px; float: center;"> </div>
				<div id="legend2" style="width: 50%; background-color: #706e6e; float: left;"></div> 	
				<div id="legend" style="width: 50%; background-color: #706e6e; float: right;"></div> 	
			</div>
		</div>

		<span id="footerSection"></span>
	</body>
</html>








