<!-- LOGIN AUTHENTICATION SCRIPT :: KPR :: 08/04/17-->
<?php
	include_once("config.php");
	$txtUName = $_POST['txtuname'];
	$txtPass = $_POST['txtPass'];
	$sql = "call sp_TeacherLogin('$txtUName','$txtPass')";
	
	$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		session_start();
		$data = mysqli_fetch_assoc($result);
		$_SESSION['Tname'] = $data["Name"];
		$_SESSION['Tlog'] = "OK";
		$_SESSION['teacherKey'] = $data['TeacherKey'];
		session_write_close();
		if(isset($_GET['x'])){
			if($_GET['x']==2){
				header("location:". $_GET['des']);
			}
			else{
				header("location:dashboard.php");
			}
		}
	}
	else
		header("location:index.php?auth=1");

?>