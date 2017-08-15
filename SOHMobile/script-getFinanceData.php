<?php
	//script-getFinanceData
	include "script-complete.php";

	$sql = "SELECT * FROM stg_tuitionfee";
	echo execSQL($sql);

?>