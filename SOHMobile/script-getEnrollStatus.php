<?php
	include "script-complete.php";
	$txtStudKey = $_POST['txtStudKey'];
	//$txtStudKey=43;
	$sql = "SELECT * from school_enrollee WHERE StudentKey = $txtStudKey ORDER BY EnrolleeKey DESC LIMIT 1";
	echo execSQL($sql);
?>
<?php
	function getYearLevel(){

	}
?>