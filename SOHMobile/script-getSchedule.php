<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	//$txtGrade = $_POST['txtGrade'];
	$txtGrade=1;
	$sql = "call sp_getSchedForEnrollment(". setSection($txtGrade) .",'2017-2018')";

	//$data = json_decode(execSQL($sql));
	//$allData = array("studentGroupCode"=>setSection($txtGrade),"studentSchedule"=>$data);
	echo execSQL($sql);
?>

<?php
	function setSection($grade){
		return 1;
	}

	function getSchoolYear(){
		return "2017-2018";
	}
?>