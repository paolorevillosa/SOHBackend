<?php
	//this will get the basic information of the system to Mobile App
	include "script-complete.php";
	$sql = "select * from information";
	echo execSQL($sql);
?>