<?php
	session_start();
    include("scripts/script-complete.php");
	if(/*count($_SESSION)<=0 &&*/isset($_SESSION['Tname'])==""){
		$des=$_SERVER['REQUEST_URI'];
		header("location:/SOH/teacher-panel?auth=2&des=$des");
	}
	$name = ($_SESSION['Tname']);
    $sql = "select * from information";
    $row = mysqli_fetch_array(exexSQLget($sql));
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row['SchoolName']; ?></title>
    <link rel="icon" 
      type="image/png" 
      href="../img/logo.png">

      <link rel="shortcut icon" href="https://www.facebook.com/rsrc.php/yl/r/H3nktOa7ZMg.ico">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../config/css/sb-admint.css" rel="stylesheet">
	<link href="../config/css/custom.css" rel="stylesheet"><!--additional CSS file::KPR::010817-->
  </head>

<!--START NAVBAR::KPR::010816-->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><?php echo $row['SchoolName']; ?></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!--<li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>-->
                        <li>
                            <a href="script-logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
					<!-- User Profile::KPR::011417 -->
					<center>
					<li>
							<br>
							<img  src="../img/def.png" width=100px height=100px/>
							<br><br>
							<label><font color=white>Teacher Panel</font></label>
							<br>
					</li>
					</center>
					<!-- END of User Profile -->
					<li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-bar-chart-o"></i> My Schedule</a>
                        <a href="grade.php"><i class="fa fa-fw fa-bar-chart-o"></i> Student Grade</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<!--END NAVBAR::KPR::010816-->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!--<script src="../modal.js"></script> ADDITIONAL JS SCRIPT FOR MODAL -->
<script src="js/customization.js"></script>
<!--<script src="Scripts/jquery-3.1.1.js"></script>-->