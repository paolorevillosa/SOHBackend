<?php
function getData($varName,$row){
	$value = "";
	$cnt = count($_GET);
	if($cnt>0){
		$value = $row["$varName"];
	}
	else{
		if($varName == "StudentNo"){
			$value = "XX - XXXX";
		}
	}
	return $value;
}

function getInfo($varName,$row){
	$value = "";
	$cnt = count($_GET);
	if($row != ""){
		$value = $row["$varName"];
	}
	return $value;
}


function gntCmb($iden,$max,$isYear){;
	if($isYear){
		for($max;$max>1980;$max--){
			if($iden==$max){
				echo '<option selected="selected">'. $max .'</option>';
			}
			else{
				echo '<option>'. $max .'</option>';
			}
		}
	}
	else{
		for($x=1;$x<$max;$x++){
			if($iden==$x){
				echo '<option selected="selected">'. $x .'</option>';
			}
			else{
				echo '<option>'. $x .'</option>';
			}
		}
	}
}


function generateStudentNo(){
	include("config.php");
	$yrToday = date("y");
	$sql = "select right(StudentNo,4) as 'suff' from stud_student where left(StudentNo,2) ='" . $yrToday ."' ORDER BY StudentKey";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$suff = $row['suff'];
		}
	}
	$suff++;
	for($x=0;$x<=2;$x++){
		$suff = "0" . $suff;
	}
	return $yrToday . "-" . $suff;	
}

function generateStudentNoV2(){
	include("config.php");
	$yrToday = date("y");
	$suff = 0;
	$sql = "select right(StudentNo,4) as 'suff' from stud_student where left(StudentNo,2) ='" . $yrToday ."' ORDER BY StudentNo";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$suff = $row['suff'];
		}

	}
	$suff++;
	for($x=0;$x<=2;$x++){
		if(strlen($suff)!=4){
			$suff = "0" . $suff;
		}
	}
	return $yrToday . "-" . $suff;	
}

//echo generateStudentNoV2();

function generateTeacherNo(){
	include("config.php");
	$sql = "select * from stg_teacher";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$id = $row['TeacherNo'];
		}
		$id++;
	}
	else{
		$id = "10001";
	}
	$conn->next_result();
	return $id;	
}

function execSQL($sql,$redLoc){
	include("config.php");
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	echo $result;
	if(($result)){
		header("location:".$redLoc);
	}
	else{
		alert("THERE IS INTERNAL ERROR...\nPLease try again later...");
	}
}

function execSQL2($sql,$redLoc){
	include("../config.php");
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	echo $result;
	if(($result)){
		header("location:".$redLoc);
	}
	else{
		alert("THERE IS INTERNAL ERROR...\nPLease try again later...");
	}
}

function execSQLajax($sql){
	include("config.php");
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if($result){
		return "true";
	}
	else{
		return "false";
	}
}

function exexSQLget($sql){
	include("config.php");
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if(mysqli_num_rows($result)>0){
		return $result;
	}
}

function customSQL($sql,$dir){
	include($dir);
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if(mysqli_num_rows($result)>0){
		return $result;
	}
}

function crudSQL($sql){
		include("config.php");
		$res = mysqli_query($conn,$sql)or die(mysqli_error($conn));
		return $res;
	}


	function getSchoolYear(){
		//date("Y-m-d");
		$month = date("m");
		$currentYear = date("Y");
		if($month>4){
			return $currentYear . "-" . ($currentYear+1);
		}
		else{
			return $currentYear-1 . "-" . $currentYear;	
		}
	}
?>