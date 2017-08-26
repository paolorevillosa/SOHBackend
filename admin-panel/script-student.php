<!-- ADD/UPDATE STUDENT SCRIPT :: KPR :: 06/06/17-->
<?php
	include("scripts/script-complete.php");
	
	//get POSTED data
	$txtLastName = $_POST['txtLName'];
	$txtFirstName = $_POST['txtFName'];
	$txtMiddleName = $_POST['txtMName'];
	$txtContact = $_POST['txtCont'];
	$txtBirthDate = $_POST['txtYear'] . "-" . $_POST['txtMonth'] . "-" . $_POST['txtDay'];
	$txtAddress = $_POST['txtAdd'];
	$txtGuardianName = $_POST['txtGrdn'];
	$txtGender = $_POST['txtGender'];
	$type="";
	$key="";
	if(isset($_POST['btnSave'])){
		$key = generateStudentNo();
		$type = 'Add';
	}
	else if(isset($_POST['btnUpdate'])){
		$key = $_GET['x'];
		$type = 'Update';
	}
	$sql = "call sp_Student". $type ."('$key','$txtLastName','$txtFirstName','$txtMiddleName','$txtAddress','$txtContact','$txtBirthDate','$txtGuardianName','$txtGender')";
	if(isset($_POST['btnOffialEnroll'])){
		$key = generateStudentNoV2();
		$Pkey = $_GET['x'];
		$sql = "UPDATE stud_student SET  isActive=1, StudentNo = '$key',username='$key',password = PASSWORD('".$key."') WHERE StudentKey = $Pkey";

		//utils for enrollment table
		$schoolYear = getSchoolYear();
		$tableGrad = getYearLevel($Pkey);
		$yearLevel = $tableGrad[0];
		$studGrp = setSection($tableGrad[1],$yearLevel);
		$sqlEnrolle = "INSERT INTO school_enrollee VALUES (null,'$Pkey','$studGrp','$yearLevel','$schoolYear',0)";



		crudSQL($sql);//update the table
		crudSQL($sqlEnrolle);//insert enroll Students

		$EnrolleeKey = getStudentEnrolleKey();
		$insertFinance = "INSERT INTO school_finance VALUES (null,'$Pkey','$EnrolleeKey','$schoolYear','9500','0','0')";
		$insertClearance = "INSERT INTO stud_clearance VALUES (null,'$Pkey','$EnrolleeKey',0,0,0)";
		crudSQL($insertFinance);//insert enroll Students
		crudSQL($insertClearance);//insert enroll Students
		header("location:student.php");
	}
	echo "<BR><BR>" . $key;

	//execSQL($sql,"student.php");
	//$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
?>


<?php
	//scripts for sectioning
	function getStudGroupKey($yearLevel){
		include "config.php";
		$sql = "SELECT * FROM stud_studentgroup WHERE YearLevelKey = $yearLevel";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['StudentGroupKey'];
		}
		return $data;
	}

	function setSection($grade,$yearLevel){
		$data = getStudGroupKey($yearLevel);
		if($grade>93){
			return $data[0];
		}
		else if($grade>85&&$grade<94){
			return $data[1];
		}
		else if($grade>80&&$grade<86){
			return $data[2];	
		}
		else if($grade<81){
			return $data[3];	
		}else{
			return $data[3];	
		}
	}

	function getYearLevel($PKey){
		include "config.php";
		$sql = "SELECT * FROM stud_grade WHERE StudentKey = $PKey ORDER BY StudentKey DESC LIMIT 1";
		$result = mysqli_query($conn,$sql);
		if(!(mysqli_num_rows($result) > 0)){
			return array(0=>1,1=>0);
		}
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['YearLevel'];
			$data[] = $row['Grade'];
		}
		return $data;	
	}

	function getStudentEnrolleKey(){
		include("config.php");
		$sql = "SELECT EnrolleeKey FROM school_enrollee ORDER BY EnrolleeKey";
		$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$suff = $row['EnrolleeKey'];
			}
		}
		return $suff;
	}
?>