<div id="wrapper">
<?php
	include("ui-navigation.php");
	include("DatatableLib.php");
	
?>
<!-- Main Content of the Page :: KPR-->
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Teacher Information
                </h1>
            </div>
        </div>
		<?php
			include("config.php");
			$sql = "select *,concat(LastName, ', ', FirstName, ' ',left(MiddleName,1)) as FullName,stg_SubjectDesc.SubjectDescription as sbj from stg_teacher
					left join stg_subjectdesc
					on stg_teacher.SubjectDescKey = stg_subjectdesc.SubjectDescKey";
			$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-10 pull-right">
					<a class="btn btn-primary pull-right" href="teacherDetails.php">Register New Teacher</a>
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>List of Teacher</h3>
					</div>
					<!-- Teacher Information -->
					<div class="panel-body">
						<table class="table table-bordered" id="mpTable">
							<thead>
								<th>Teacher No.</th>
								<th>Name</th>
								<th>Subject</th>
								<th>Yr. Lvl</th>
								<th>Actions</th>
                            </thead>
							<tbody>
								
									<?php
										if(mysqli_num_rows($result) > 0){
											while($row = mysqli_fetch_assoc($result)){
												$id = $row['TeacherKey'];
									?>
									<tr>
									<td><?php echo $row['TeacherNo'];?></td>
									<td><?php echo $row['FullName'];?></td>
									<td><?php echo $row['sbj'];?></td>
									<td><?php echo $row['YearLevelKey'];?></td>
									<td>
										<form method="post" action=<?php echo 'script-delete.php?id='. $id . "&type=teacher&loc=" . $_SERVER['REQUEST_URI']?>>
											<a class="btn btn-primary btn-xs" href="<?php echo 'teacherDetails.php?key='.$id?>">Update</a>
											<input class="btn btn-danger btn-xs" type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this?');" />
										</form>
									</td>
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
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>