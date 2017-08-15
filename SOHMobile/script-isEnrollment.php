<?php
	//script for isEnrollment
	include "config.php";
	$sql = "select * from school_enrollment_period";
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);
	$a = $row['isEnrollemt'];
	$date = $row['dateCreated'];
	$untilDate = $row['untilDate'];
	$res = array('id'=>120494,'isEnrollment'=>$a,'datePosted'=>$date,'untilDate'=>$untilDate);
	echo json_encode($res);
?>