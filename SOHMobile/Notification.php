<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	//$txtStudKey = $_POST['txtStudKey'];
	//$txtStudKey = 2;
	$date = date("Y-m-d");
	$sql = "SELECT * FROM stud_notification WHERE PostUntil >= '$date'";
	echo execSQL($sql);
?>