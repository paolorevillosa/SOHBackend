<!-- LOGOUT SCRIPT :: KPR :: 12/04/17-->
<?php
	session_start();
	unset($_SESSION['name']);
	unset($_SESSION['log']);
	header("location:/SOH/admin-panel");
?>