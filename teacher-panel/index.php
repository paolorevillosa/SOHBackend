<!DOCTYPE html>
<?php
	include("scripts/script-complete.php");
	$sql = "select * from information";
	$row = mysqli_fetch_array(exexSQLget($sql));
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row['SchoolName']; ?></title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../config/css/custom.css" rel="stylesheet"><!--additional CSS file::KPR::010817-->
  </head>
  <body>
	<!--START LOGIN PAGE::KPR::010816-->
	<center>
	<div class="container">
	<div class="card card-container">
		<center>
		<img id="profile-img" class="profile-img-card" src="<?php echo $row['SchoolLogo']; ?>"" width="100%" height="100%"/>
            <p id="profile-name" class="profile-name-card"></p>
			<?php
				$iden=0;
				$des='';
				if(count($_GET)>0){
					$iden = (($_GET['auth']));
					if($iden==1){
						echo '<div class="alert alert-danger">
						Incorrect username or password
						</div>';
					}
					else if($iden==2){
						echo '<div class="alert alert-danger">
						You must login first
						</div>';
						$des = $_GET['des'];
					}
				}
			?>
		<form method="post" class="form-signin" action=<?php echo "script-log-auth.php?x=$iden&des=$des"?>>
			<input type="text" placeholder="Username" class="form-control" name="txtuname" required autofocus>
			<input type="password" placeholder="Password" class="form-control" name="txtPass" required>
			<button type="submit" value="LOGIN" class="btn btn-lg" name="btnSub">LOGIN</button>
		</form>
		</center>
	</div>
	</div>
	<!--END::KPR::010816-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>	
</html>