<?php

echo checkFirst('asdasd	','asdasdasd','asdasdasd');
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