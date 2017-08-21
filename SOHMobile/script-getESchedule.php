<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	$txtStudentGroupKey = $_POST['txtStudentGroupKey'];
	$txtSchoolYear = $_POST['txtSchoolYear'];
	/*$txtStudentGroupKey = 3;
	$txtSchoolYear = "2017-2018";*/
	$sql = "call sp_getSchedForEnrollment(". $txtStudentGroupKey .",'" . $txtSchoolYear . "')";
	echo execSQL($sql);
?>