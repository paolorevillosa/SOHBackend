<?php
	//this will get the student section base on Grade
	include "script-complete.php";
	$studentKey = $_POST['txtStudentKey'];
	//$studentKey = 43;
	$sql = "select * from stud_grade WHERE StudentKey = $studentKey";
	$result = execSQLReturnRes($sql);
	if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$r[] = $row;
			}
			echo json_encode($r);
	}

?>