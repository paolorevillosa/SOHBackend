<div id="wrapper">
<?php include("ui-navigation.php"); ?>
<!-- Main Content of the Page :: KPR-->
<body onload="hideAll1()">
<div id="page-wrapper">
	<div class="container-fluid">
	<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
                <h1 class="page-header"> Scheduling Information</h1>
			</div>
		</div>
	
		<!--filtering section-->
		<div class="row table-responsive">
			<div class="col-lg-12">
				<form>
				<table class="table">
					<tr>
						<td><input type="text" class="form-control" placeholder="test1"></td>
						<td><input type="text" class="form-control" placeholder="test2"></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
		
		<?php
			include("config.php");
			$sql = "select * from vw_scheduleinfo";
			$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
		?>
		<div class="row" id="myDIV1">
            <div class="col-lg-12">
				<div class="panel panel-default table-responsive">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Maintenance</h3>
                    </div>
                    <div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Subject Code</th>
									<th>Subject Description</th>
									<th>Time</th>
									<th>Teacher</th>
								<tr>
							</thead>
                            <tbody>
								<?php
									if(mysqli_num_rows($result) > 0 ){
										while($row = mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td><?php echo $row["SubjectCode"];?></td>
									<td><?php echo $row["SubjectDescription"];?></td>
									<td><?php echo $row["Details"];?></td>
									<td><?php echo $row["LastName"];?></td>
                                </tr>
								<?php
										}
									}
								?>
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>
		</div>
		
	</div>
</div>
<!-- End Main Content :: KPR -->
</div>
<script src="js/customization.js"></script>
</body>