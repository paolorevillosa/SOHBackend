<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	$txtStudKey = $_POST['txtStudKey'];
	//$txtStudKey = 42;
	$date = date("Y-m-d");
	$sql = "SELECT * FROM stud_notification_v2 WHERE PostUntil >= '$date' AND StudentKey = $txtStudKey";
	echo execSQL($sql);
?>