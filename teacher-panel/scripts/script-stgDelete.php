<?php
	//delete script for all stg

	include "script-complete.php";
	$id = $_GET['id'];
	$stg = $_GET['type'];

	if($stg=="books"){
		$sql = "delete from stg_books where BookKey = '$id'";
	}
	else if($stg=="subjects"){
		$sql = "delete from stg_subjects where SubjectKey = '$id'";	
	}
	else if($stg=="uniform"){
		$sql = "delete from stg_uniform where UniformKey = '$id'";	
	}


	execSQL2($sql,"../dashboard.php");
?>
