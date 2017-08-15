<?php
	include("scripts/script-complete.php");
	$id = $_GET['id'];
	$type = $_GET['type'];
	$loc = $_GET['loc'];

	if($type == "student"){
		$sql = "delete from stud_student where StudentKey = '$id'";
	}
	else if($type == "teacher"){
		$sql = "delete from stg_teacher where TeacherKey = '$id'";	
	}

	execSQL($sql,$loc);
?>