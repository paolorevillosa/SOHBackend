<div id="wrapper">
<?php include("ui-navigation.php"); ?>
<!-- Main Content of the Page :: KPR-->
<body  onload="hideAll()">
<div id="page-wrapper">
	<div class="container-fluid">
	<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
                <h1 class="page-header"> Settings and Configuration Manager</h1>
			</div>
		</div>
		
		<!-- Xtra navbar for settings menu-->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-sett" aria-expanded="false" id="nav">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#"></a>
				</div>
				
				
				<div class="collapse navbar-collapse" id="nav-sett">
				  <ul class="nav navbar-nav">
					<li onclick="showDiv(1,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">Finance</a></li>
					<li onclick="showDiv(2,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">Subject</a></li>
					<li onclick="showDiv(3,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">List of Books</a></li>
					<li onclick="showDiv(4,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">School Information</a></li>
					<li onclick="showDiv(5,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">Uniform</a></li>
					<li onclick="showDiv(6,6)" class="btn btn-xs"><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in">Notification and Enrollment</a></li>
				  </ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
		

		<div class="row hideDiv" id="myDIV6">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Notifications</h3>
                    </div>
					<!-- This is filter -->
					<div class="panel-body">
					
						<?php include("stg_Notifications.php");?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row hideDiv" id="myDIV3">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Books</h3>
                    </div>
					<!-- This is filter -->
					<div class="panel-body">
					
						<?php include("stg_Books.php");?>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row hideDiv" id="myDIV4">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>School Basic Information</h3>
                    </div>
                    <div class="panel-body">
                    	<?php include("stg_SchoolInfo.php") ?>
                    </div>
				</div>
			</div>
		</div>


		<div class="row hideDiv" id="myDIV5">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>School Uniform</h3>
                    </div>
                    <div class="panel-body">
                    	<?php include("stg_Uniform.php") ?>
                    </div>
				</div>
			</div>
		</div>

		<div class="row hideDiv" id="myDIV1">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                	    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i></h3>
                    </div>
                    <div class="panel-body">
								<?php include "stg_Finance.php" ?>
                    </div>
                </div>
            </div>
		</div>
		
		<div class="row hideDiv" id="myDIV2">
			<div class="col-lg-12">
				
					<?php include("stg_Subject.php");?>
				
			</div>
		</div>
	</div>
</div>
</div>
</body>


<script type="text/javascript">

	function disablenable(){
		for($x=1;$x<=4;$x++){
			document.getElementById("txtSInfo"+$x).disabled = !document.getElementById("txtSInfo"+$x).disabled;
		}
		document.getElementById("btnSave").disabled = !document.getElementById("btnSave").disabled;
		if($("#btnUpdate").text()=="Update"){
			$("#btnUpdate").text("Cancel");	
		}
		else{
			$("#btnUpdate").text("Update");	
			$('#img').attr('src', $("#txtOriginal").val());
			$("#txtSInfo2").val("");
		}
	}

	
</script>