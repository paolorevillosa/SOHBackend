<?php
	//mobile-script LOGIN
	include "script-complete.php";
	$txtUName = $_POST['txtUName'];
	$txtUPass = $_POST['txtUPass'];
	//$txtUPass="1";
	//$txtUName="1";
	$sql = "call sp_StudentLogin('$txtUName','$txtUPass')";
	$studData = json_decode(execSQL($sql));
	if($studData!=null){
		echo json_encode($studData);
		return;
	}
	$sql2 = "SELECT * FROM tempStudTable WHERE FirstName = '$txtUName' AND LASTNAME = '$txtUPass'";
	$tempData = json_decode(execSQL($sql2));
	if($tempData!=null){
		echo json_encode(array(array("isOk"=>"0")));
	}
?>