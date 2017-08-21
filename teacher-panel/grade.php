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

							$sql = "SELECT a.StudentKey,c.StudentNo,concat(c.LastName,' ', c.FirstName) as NAME FROM school_enrollee a
									LEFT JOIN stud_student c
									ON c.StudentKey = a.StudentKey
									WHERE a.StudentGroupKey IN (SELECT StudentGroupKey 
									FROM school_schedule WHERE AdviserKey = /*$key*/4)
									ORDER BY StudentKey";
							$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
						?>
						<table class="table">
							<?php
								if(mysqli_num_rows($result) > 0){
									
							?>
							<tr>
								<table class="table table-bordered">
									<thead>
										<th>StudentKey</th>
										<th>Name</th>
										<th>Grade</th>

		                            </thead>
									<tbody>
										
											<?php
													while($row = mysqli_fetch_assoc($result)){
														$id = $row['StudentKey'];
											?>
											<tr>
											<td><?php echo $row['StudentNo'];?></td>
											<td><?php echo $row['NAME'];?></td>
											<td class="col-md-1"><input type="text" class="form-control"></td>
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
							<th class="text-center">NO ADVISORY CLASS</th>
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