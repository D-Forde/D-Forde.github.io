<?php
$username = "root";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("pmd",$dbhandle) 
  or die("Could not select flot");
$res = mysql_query("SELECT *  from  emp where times between '19/01/2015 00:00:00' and '20/01/2015 23:45:00';");
$result = mysql_query("SELECT resp_rate, UNIX_TIMESTAMP(times) as times from records where (hour(times) between 0 and 23) AND mrn='654321' ORDER BY times ASC");
$yvalue = array();
$xvalue = array();
$flotData= array();

while ($row = mysql_fetch_assoc($result)) {
$xvalue[] = $row['times'];
$yvalue[] = $row['resp_rate'];

}

$jsonData = json_encode($flotData, true);
?>

<!doctype html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
	<link type="text/css" rel="stylesheet" href="../src/css/graph.css">
	<link type="text/css" rel="stylesheet" href="../src/css/detail.css">
	<link type="text/css" rel="stylesheet" href="../src/css/legend.css">
	<link type="text/css" rel="stylesheet" href="css/extensions.css?v=2">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.js"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>




	<script src="../vendor/d3.v3.js"></script>

	<script src="../src/js/Rickshaw.js"></script>
	<script src="../src/js/Rickshaw.Class.js"></script>
	<script src="../src/js/Rickshaw.Compat.ClassList.js"></script>
	<script src="../src/js/Rickshaw.Graph.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.Area.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.Line.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.Bar.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.ScatterPlot.js"></script>
	<script src="../src/js/Rickshaw.Graph.Renderer.Stack.js"></script>
	<script src="../src/js/Rickshaw.Graph.RangeSlider.js"></script>
	<script src="../src/js/Rickshaw.Graph.RangeSlider.Preview.js"></script>
	<script src="../src/js/Rickshaw.Graph.HoverDetail.js"></script>
	<script src="../src/js/Rickshaw.Graph.Annotate.js"></script>
	<script src="../src/js/Rickshaw.Graph.Legend.js"></script>
	<script src="../src/js/Rickshaw.Graph.Axis.Time.js"></script>
	<script src="../src/js/Rickshaw.Graph.Behavior.Series.Toggle.js"></script>
	<script src="../src/js/Rickshaw.Graph.Behavior.Series.Order.js"></script>
	<script src="../src/js/Rickshaw.Graph.Behavior.Series.Highlight.js"></script>
	<script src="../src/js/Rickshaw.Graph.Smoother.js"></script>
	<script src="../src/js/Rickshaw.Fixtures.Time.js"></script>
	<script src="../src/js/Rickshaw.Fixtures.Time.Local.js"></script>
	<script src="../src/js/Rickshaw.Fixtures.Number.js"></script>
	<script src="../src/js/Rickshaw.Fixtures.RandomData.js"></script>
	<script src="../src/js/Rickshaw.Fixtures.Color.js"></script>
	<script src="../src/js/Rickshaw.Color.Palette.js"></script>
	<script src="../src/js/Rickshaw.Graph.Axis.Y.js"></script>
	<script src="../src/js/Rickshaw.Graph.Axis.X.js"></script>

		<style>
		body { 
			font-family: Arial, sans-serif 
		}

		#chart-container{
			width:95%;
		}
		#chart{
			top:6px;
			left:40px;
		}
		#timeline{
			left:40px;
			height:20px;
		}		
		#preview{
			left:80px;	
			margin:0 auto;	
		}
		#legend {
			display:block;
			text-align: center;
		}
		#y_axis {
			position: absolute;
			top: 15px;
			bottom: 0;
			width:30px;
		}
		#x_axis {
			position: relative;
			top:15px;
			left: 30px;
			height:10px	;
		}
	</style>
	</head>
	<body>
	<div id="chart-container">
		<div id="y_axis"></div>
		<div id="chart"></div>
		<div id="x_axis"></div>
		<div id="timeline"></div>		
		<div id="legend" style="margin:0 auto;"></div>

		<div id="preview" style="left:35px;"></div>
	</div>
<script>
	var margin = {top: 20, right: 20, bottom: 30, left: 50};
    var width = window.innerWidth * 0.90;
    var height = window.innerHeight * 0.55;





var one = [];
var two =   [];
var data = <?php
	$len = count($xvalue);
		echo "[";
	for($i=0;$i < $len;$i++){
		echo "{";
		echo 'x: '.$xvalue[$i].',';
		echo ' y: '.$yvalue[$i];
		echo "},";
	}
		echo "];";
?>



var graph = new Rickshaw.Graph( {
	width: width,
	height:height,
	interpolation: 'linear',
	element: document.getElementById("chart"),
	renderer: 'line',
	padding: { top: 0.1 },
	series: [
		{
			color: "steelblue",
			data: data,
			name: 'BPM'
		}
	]
} );

var time = new Rickshaw.Fixtures.Time();
var hours = time.unit('hour');

var x_ticks = new Rickshaw.Graph.Axis.Time( {
	graph: graph,
	timeUnit: hours
} );
var y_ticks = new Rickshaw.Graph.Axis.Y( {
	graph: graph,
	orientation: 'left',
	tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
	element: document.getElementById('y_axis')
} );

var preview = new Rickshaw.Graph.RangeSlider.Preview( {
	graph: graph,
	element: document.getElementById('preview'),
} );

var annotator = new Rickshaw.Graph.Annotate({
    graph: graph,
    element: document.getElementById('timeline')
});

annotator.add(1421628300, '00:45 - Event #10   Duration:25 sec'); //00:45
annotator.add(1421635500, '02:45 - Event #11   Duration:15 sec'); //02:45
annotator.add(1421653500, '07:45 - Event #12   Duration:11 sec'); //07:45
annotator.add(1421671500, '12:45 - Event #13   Duration:18 sec'); //12:45
annotator.add(1421696700, '19:45 - Event #14   Duration:23 sec'); //19:45
annotator.add(1421711100, '23:45 - Event #15   Duration:10 sec'); //23:45
annotator.update();

graph.render();



var legend = document.querySelector('#legend');

var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {

	render: function(args) {

		legend.innerHTML = args.formattedXValue;

		args.detail.sort(function(a, b) { return a.order - b.order }).forEach( function(d) {

			var line = document.createElement('div');
			line.className = 'line';

			var swatch = document.createElement('div');
			swatch.className = 'swatch';
			swatch.style.backgroundColor = d.series.color;

			var label = document.createElement('div');
			label.className = 'label';
			label.innerHTML = d.name + ": " + d.formattedYValue;

			line.appendChild(swatch);
			line.appendChild(label);

			legend.appendChild(line);

			var dot = document.createElement('div');
			dot.className = 'dot';
			dot.style.top = graph.y(d.value.y0 + d.value.y) + 'px';
			dot.style.borderColor = '#F00';

			this.element.appendChild(dot);

			dot.className = 'dot active';

			this.show();

		}, this );
        }
});

var hover = new Hover( { graph: graph } );


$(window).resize(function(){
  graph.configure({
    width: window.innerWidth * 0.75,
    height: window.innerHeight * 0.5,
  });
  graph.render();
});


</script>

<div class="table-responsive"style="overflow:auto; height:200px;">
<table id="mytable" class="table table-bordred table-striped" style=" margin:0 auto; margin-top:50px;">
   
   <thead>
   
   <th>Event #</th>
    <th>Position</th>
     <th>Type</th>
     <th>Time</th>
     <th>Duration</th>

   </thead>
    <tbody>
    
    <tr>
    <td>10</td>
    <td>Back</td>
    <td>Apnea</td>
    <td>00:45:00</td>
    <td>25 sec</td>
</tr>
    
 <tr>
    <td>11</td>
    <td>Left</td>
    <td>Apnea</td>
    <td>02:45:00</td>
    <td>15 sec</td>
</tr>
    
    
 <tr>
    <td>12</td>
    <td>Right</td>
    <td>Hypopnea</td>
    <td>07:45:00</td>
    <td>11 sec</td>
    </tr>

     <tr>
    <td>12</td>
    <td>Right</td>
    <td>Hypopnea</td>
    <td>12:45:00</td>
    <td>18 sec</td>
    </tr>

        
    </tbody>
        
</table>
</div>

</body>
</html>