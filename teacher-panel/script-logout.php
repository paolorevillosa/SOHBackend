<!-- LOGOUT SCRIPT :: KPR :: 12/04/17-->
<?php
	session_start();
	unset($_SESSION['Tname']);
	unset($_SESSION['Tlog']);
	unset($_SESSION['teacherKey']);
	header("location:/SOH/teacher-panel");
?>