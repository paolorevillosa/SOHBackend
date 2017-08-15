<?php
	//START Connection Start::KPR::010717
	$mysql_hostname = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_database = "db_SOH";
	$prefix = "";
	$conn = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
	if(!$conn){
		die("Connection Failed. ". mysqli_connect_error());
	}
	//END OF Connection::KPR
?>