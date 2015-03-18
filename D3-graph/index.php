<?php
$username = "root";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("pmd",$dbhandle) 
  or die("Could not select flot");

$result = mysql_query("SELECT resp_rate, times from records where (hour(times) between 1 and 23) AND mrn='654321'");
$yvalue = array();
$xvalue = array();
$flotData= array();

while ($row = mysql_fetch_assoc($result)) {
$xvalue[] = date("H:i",strtotime($row['times']));
$yvalue[] = $row['resp_rate'];

}

$jsonData = json_encode($flotData, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>D3 Test</title>
    <script type="text/javascript" src="d3.js"></script>
    <script type="text/javascript" src="d3.min.js"></script>
    <style type="text/css">
    path {
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
	}
	 
	line {
	    stroke: black;
	}
	 
	text {
	    font-family: Arial;
	    font-size: 9pt;
	}
	circle:hover{
		fill:red;
	}

	div.tooltip {   
  position: fixed;           
  text-align: center;           
  width: 250px;                  
  height: 30px;                 
  padding: 2px;             
  font: 12px sans-serif;        
  background: white;
  color:black;   
  border: 0px;      
  border-radius: 8px;           
  pointer-events: none;         
}
	</style>
</head>
<body>
    <script type="text/javascript">
var data =     
	var margin = {top: 20, right: 20, bottom: 30, left: 50};
    var width = 1860 - margin.left - margin.right;
    var height = 900 - margin.top - margin.bottom;
    var parseDate = d3.time.format("%H:%M").parse;
    var x = d3.time.scale().range([0, width]);
    var y = d3.scale.linear().range([height, 0]);
	var xAxis = d3.svg.axis()
	    .scale(x)
	    .orient("bottom")
	    .ticks(24)
	    .tickFormat(d3.time.format("%H:%M"));

    var yAxis = d3.svg.axis()
        .scale(y)
        .ticks(d3.max(data, function(d) {
		      return d.resp / 5;
		    }))
        .orient("left");

    var line = d3.svg.line()
        .x(function(d) { return x(d.times); })
        .y(function(d) { return y(d.resp); });


    var svg = d3.select("body").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      	.append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    data.forEach(function(d) {
        d.times = parseDate(d.times);
        d.resp = +d.resp;
    });

    x.domain(d3.extent(data, function(d) { return d.times; }));
    y.domain(d3.extent(data, function(d) { return d.resp;}));

    svg.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .call(xAxis);

    svg.append("g")
          .attr("class", "y axis")
          .call(yAxis)
          .append("text")
          .attr("transform", "rotate(-90)")
          .attr("x", -350)
          .attr("y", -40)
          .attr("dy", ".71em")
          .style("text-anchor", "end")
          .text("Breaths Per Minute (BPM)");
    svg.append("g")
    	  .attr("class", "label")
    	  .append("text")
    	  .attr("x",775)
    	  .attr("y",35)
    	  .text("Time: XX:XX" + " BPM: YY")
    	  .style("font","25px sans-serif");

    svg.append("path")
          .datum(data)
          .attr("class", "line")
          .attr("d", line);


	var formatTime = d3.time.format("%H:%M");
    var div = d3.select("body")
			    .append("div")   
			    .attr("class", "tooltip")
			    .style("opacity", 1);

	svg.selectAll("dot")    
        .data(data)         
    	.enter().append("circle")          
        .attr("r", 4)       
        .attr("cx", function(d) { return x(d.times); })       
        .attr("cy", function(d) { return y(d.resp); })     
        .on("mouseover", function(d) {      
            div.transition()        
                .duration(1)      
                .style("opacity", 1);      
            div .html("Time: "+ formatTime(d.times) + " BPM: "  + d.resp)  
                .style("left", 830 + "px")     
                .style("top", 40 + "px")
                .style("font", "25px sans-serif");    
            })                  
        .on("mouseout", function(d) {       
            div.transition()        
                .duration(1)      
                .style("opacity", 0);   
        });
    </script>
    <div class="chart-container"></div>
</body>
</html>  