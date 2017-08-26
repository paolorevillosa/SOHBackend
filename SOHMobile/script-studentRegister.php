<?php
	include "script-complete.php";
	$txtLastName = $_POST['txtLastName'];
	$txtFirstName = $_POST['txtFirstName'];
	$txtMiddleName = $_POST['txtMiddleName'];
	$txtContact = $_POST['txtContact'];
	$txtBdate = $_POST['txtBdate'];
	$txtGuardianName = $_POST['txtGuardianName'];
	$txtGender = $_POST['txtGender'];
	//$txtAddress =$_POST['txtAddress'];
	$studentNo = generateStudentNo();
	$txtOnChild = $_POST['txtOnChild'];

	//for gradeTable
	$txtStatus = $_POST['txtStatus'];
	$txtYearLevel = yearLevel($_POST['txtYearLevel']);
	$txtGrade = $_POST['txtGrade'];
	$txtSchoolFrom = $_POST['txtSchoolFrom'];
	
	$txtProcessType = $_POST['processType'];
	$txtPassword = $_POST['newPassword'];

	//additional for address
	$txtHouseNo = $_POST['txtHouseNo'];
	$txtSubdVill = $_POST['txtSubdVill'];
	$txtCity = $_POST['txtCity'];
	$txtBarangay = $_POST['txtBarangay'];

	if($txtProcessType == 0){
		if(checkFirst($txtLastName,$txtFirstName,$txtMiddleName)!=0){
			echo "0";
			return;
		}

		/*$sql = "call sp_StudentAdd('','$txtLastName','$txtFirstName','$txtMiddleName','$txtOnChild','$txtAddress','$txtContact','$txtBdate','$txtGuardianName','$txtGender')";*/
		$sql = "call sp_StudentAddV2('','$txtLastName','$txtFirstName','$txtMiddleName','$txtContact','$txtBdate','$txtGuardianName','$txtGender','$txtOnChild','$txtHouseNo','$txtSubdVill','$txtBarangay','$txtCity')";
		//$result = execSQLReturnRes($sql);
		$studentKey = getNextKey();
		$sqlGrade = "INSERT INTO stud_grade(StudentKey,Status,SchoolFrom,Grade,YearLevel) 
		VALUES ('$studentKey','$txtStatus','$txtSchoolFrom','$txtGrade','$txtYearLevel')";
		$result = execSQLReturnRes($sql);
		$result2 = execSQLReturnRes($sqlGrade);
		if($result||$result2){
			echo "1";
		}
	}
	else{
		//update
		$editPass = $txtPassword != "" ? " ,stud_student.password = password('$txtPassword') ": "";
		$key = $_POST['txtKeyId'];
		$sql = "UPDATE stud_student SET
				stud_student.LastName = '$txtLastName',
				stud_student.FirstName = '$txtFirstName',
				stud_student.MiddleName = '$txtMiddleName',
				stud_student.Address = '$txtAddress',
				stud_student.ContactNo = '$txtContact',
				stud_student.DOB = '$txtBdate',
				stud_student.GuardianName = '$txtGuardianName',
				stud_student.Gender = '$txtGender',
				stud_student.isOnlyChild = '$txtOnChild'
				".
				$editPass . 
				"where stud_student.StudentKey = $key";

		$result = execSQLReturnRes($sql);
		if($result){
			echo "1";
		}

	}
	
?>

<?php
//addition functions
function generateStudentNo(){
	include("config.php");
	$yrToday = date("y");
	//
	$sql = "select right(StudentNo,4) as 'suff' from stud_student where left(StudentNo,2) ='" . $yrToday ."' ORDER BY StudentNo";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$suff = $row['suff'];
		}

	}
	$suff++;
	for($x=0;$x<=2;$x++){
		//if(suff.length()!=4){
			$suff = "0" . $suff;
		//}
	}
	return $yrToday . "-" . $suff;	
}

function getNextKey(){
	include("config.php");
	$sql = "SELECT StudentKey FROM stud_student ORDER BY StudentKey";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$suff = $row['StudentKey'];
		}
	}
	return $suff;
}

function yearLevel($txtYearLevel){
	if($txtYearLevel=="Second Year"){
		return 1;
	}
	else if($txtYearLevel=="Third Year"){
		return 2;
	}
	else if($txtYearLevel=="Fourth Year"){
		return 3;
	}
}

function getGender($gender){
	if($gender=="Male"){
		return "M";
	}
	else{
		return "F";
	}
}

function checkFirst($LastName,$FirstName,$MiddleName){
	include("config.php");
	$val = 0;
	$sql = "SELECT count(*) as 'avail' FROM stud_student
			WHERE LastName = '$LastName' AND
			FirstName = '$FirstName' AND
			MiddleName = '$MiddleName'";
	$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);
	$val = $row['avail'];
	return $val;
}
?>