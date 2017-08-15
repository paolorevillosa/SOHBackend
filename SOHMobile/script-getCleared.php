<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	$txtStudKey = $_POST['txtStudKey'];
	//$txtStudKey = 2;
	$sql = "SELECT * FROM stud_clearance WHERE StudentKey = $txtStudKey ORDER BY ClearanceKey DESC LIMIT 1";
	$sqlFinance = "CALL sp_FinanceUtils($txtStudKey)";
	$data = json_decode(execSQL($sql));
	$dataFin = json_decode(execSQL($sqlFinance));
	echo json_encode(array("gen"=>$data,"PendingAmount"=>$dataFin));
?>