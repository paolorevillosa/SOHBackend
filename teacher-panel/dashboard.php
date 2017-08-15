<div id="wrapper">
<?php include("ui-navigation.php"); 
	$key = ($_SESSION['teacherKey']);

?>
<!-- Main Content of the Page :: KPR-->
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Schedule Information
                </h1>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>My Class Schedule</h3>
					</div>
					<!-- SchedInfo Information -->
					<div class="panel-body">
						<?php 
							include "config.php";

							$sql = "SELECT z.ScheduleKey,a.SubjectDescription,b.StudentGroupName,c.Details
							 FROM school_schedule z
							 LEFT JOIN stg_subject a
							 ON z.SubjectKey = a.SubjectKey
							 LEFT JOIN stud_studentgroup b
							 ON z.StudentGroupKey = b.StudentGroupKey
							 LEFT JOIN stg_time c
							 ON c.TimeKey = z.TimeKey
							 WHERE TeacherKey = $key";
							$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
						?>
						<table class="table">
							<?php
								if(mysqli_num_rows($result) > 0){
									
							?>
							<tr>
								<table class="table table-bordered">
									<thead>
										<th>Subject</th>
										<th>Section</th>
										<th>Time</th>

		                            </thead>
									<tbody>
										
											<?php
													while($row = mysqli_fetch_assoc($result)){
														$id = $row['ScheduleKey'];
											?>
											<tr>
											<td><?php echo $row['SubjectDescription'];?></td>
											<td><?php echo $row['StudentGroupName'];?></td>
											<td><?php echo $row['Details'];;?></td>
											</tr>
											<?php
													}
											?>
										
									</tbody>
								</table>
							</tr>
							<?php
								}
								else{
							?>
							<th class="text-center">NO DATA FOUND</th>
							<?php
								}
							?>
						</table>
						
					</div>
				</div>
			</div>
		</div>
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>
</html>