<?php
	//add data to school enrolle and finance details
	include "script-complete.php";
	$txtYearLevel = $_POST['txtYearLevel'];
	$txtStudentKey = $_POST['txtStudentKey'];
	$txtStudentGroupKey = $_POST['txtStudentGroupKey'];
	$txtSchoolYear = $_POST['txtSchoolYear'];
	$txtStatus = $_POST['txtStatus'];

	$txtTuitionAmount = $_POST['txtTuitionAmount'];
	$txtBookFee = $_POST['txtBookFee'];
	$txtUniformAmount = $_POST['txtUniformAmount'];

	
	$insertEnrolle = "INSERT INTO school_enrollee VALUES (null,'$txtStudentKey','$txtStudentGroupKey','$txtYearLevel','$txtSchoolYear','$txtStatus')";
	$EnrolleeKey = getStudentEnrolleKey();
	$insertFinance = "INSERT INTO school_finance VALUES (null,'$txtStudentKey','$EnrolleeKey','$txtSchoolYear','$txtTuitionAmount','$txtUniformAmount','$txtBookFee')";
	$insertClearance = "INSERT INTO stud_clearance VALUES (null,'$txtStudentKey','$EnrolleeKey',0,0,0)";
	if(execSQLReturnRes($insertEnrolle) && execSQLReturnRes($insertFinance) && execSQLReturnRes($insertClearance)){
		echo "SUCCESS";
	}
	else{
		echo "FAILED";
	}
?>


<?php
	//functions and methods
	function getStudentEnrolleKey(){
		include("config.php");
		$sql = "SELECT EnrolleeKey FROM school_enrollee ORDER BY EnrolleeKey";
		$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$suff = $row['EnrolleeKey'];
			}
		}
		return $suff+1;
	}



?>