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
$xvalue[] = $row['times'];
$yvalue[] = $row['resp_rate'];

}

$jsonData = json_encode($flotData, true);
?>


<!DOCTYPE html>
<html>
<head>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  <script src="../morris.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
  <script src="lib/example.js"></script>
  <link rel="stylesheet" href="/lib/example.css">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
  <link rel="stylesheet" href="../morris.css">
<meta charset=utf-8 />
<title>Morris.js Area Chart Example</title>
</head>
<body>
  <div id="area-example"></div>
 <script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
Morris.Area({
  element: 'area-example',
  data: 	
  <?php $len = count($xvalue);
		echo "[";
	for($i=0;$i < ($len-1);$i++){
		echo "{";
		echo '"times" : "'.$xvalue[$i].'",';
		echo '"resp" : "'.$yvalue[$i].'",';
		echo "},";
	}
		echo "],";
	?>
  xkey: 'times',
  ykeys: ['resp'],
  labels: ['BPM']
});

 </script>
</body>
</html>
