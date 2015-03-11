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

$jsonData = json_encode($xvalue, true);
$json = json_encode($yvalue, true);


		echo "[";
	for($i=0;$i < 8;$i++){
			echo "[".$i." , ".rand(-1,1)."],";
	}
		echo "];";
?>
