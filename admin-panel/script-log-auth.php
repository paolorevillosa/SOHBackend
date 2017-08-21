<!-- LOGIN AUTHENTICATION SCRIPT :: KPR :: 08/04/17-->
<?php
	include_once("config.php");
	$txtUName = $_POST['txtuname'];
	$txtPass = $_POST['txtPass'];
	$sql = "SELECT *,concat(LastName, ' ' ,FirstName,' ',MiddleName) as Name FROM main_admin 
			WHERE UserName = '$txtUName' AND Password = password('$txtPass')";
	
	$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		session_start();
		$data = mysqli_fetch_assoc($result);
		$_SESSION['name'] = $data["Name"];
		$_SESSION['log'] = "OK";
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