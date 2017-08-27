<!-- ADD/UPDATE TEACHER SCRIPT :: KPR :: 06/06/17-->
<?php
	include("scripts/script-complete.php");

	//get POSTED data
	$txtLastName = $_POST['txtLName'];
	$txtFirstName = $_POST['txtFName'];
	$txtMiddleName = $_POST['txtMName'];
	$txtContact = $_POST['txtCont'];
	$txtBirthDate = $_POST['txtYear'] . "-" . $_POST['txtMonth'] . "-" . $_POST['txtDay'];
	$txtAddress = $_POST['txtAdd'];
	$txtYearLevel = $_POST['txtYearLevelKey'];
	$txtSbjCode = $_POST['sbjCode'];
	$txtCivilStatus = $_POST['CivilStatus'];

	if(isset($_POST['btnSave'])){
		$key = generateTeacherNo();
		
		$sql = "INSERT into stg_teacher values (null,'$key','$txtLastName','$txtFirstName','$txtMiddleName','$txtAddress','$txtContact','$txtBirthDate','$txtYearLevel',(select SubjectKey from stg_Subject where Comments like ('%". $txtSbjCode ."%')),'$txtSbjCode','$txtCivilStatus','$key',password('$key'))";
	}
	else if(isset($_POST['btnUpdate'])){
		$key = $_GET['x'];
		$sql = "UPDATE stg_teacher SET
				stg_teacher.LastName = '$txtLastName',
				stg_teacher.FirstName = '$txtFirstName',
				stg_teacher.MiddleName = '$txtMiddleName',
				stg_teacher.Address = '$txtAddress',
				stg_teacher.ContactNo = '$txtContact',
				stg_teacher.DOB = '$txtBirthDate',
				stg_teacher.YearLevelKey = '$txtYearLevel',
				stg_teacher.SubjectKey = (select SubjectKey from stg_Subject where Comments like ('%" . $txtSbjCode . "%')),
				stg_teacher.SubjectDescKey = '$txtSbjCode',
				stg_teacher.CivilStatusKey = '$txtCivilStatus'
				where TeacherKey = '$key'";
	}
	execSQL($sql,"teacher.php");
?>