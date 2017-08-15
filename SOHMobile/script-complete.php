<?php
	//function for CRUD Operation-Mobile
	function execSQL($sql){
		include "config.php";
		$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$r[] = $row;
			}
			return json_encode($r);
		}
	}

	function execSQLReturnRes($sql){
		include "config.php";
		$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
		return $result;
	}

?>