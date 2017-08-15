<div class="row">
	<?php
		$sql = "select * from stg_SubjectDesc";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	?>
	<div class="col-lg-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Subject Offer</h3>
			</div>
			<div class="panel-body">
				<div class="col-lg-10 pull-right">
					<a class="btn btn-primary pull-right" href="studentDetails.php">Add New Subject</a>
				</div>
			</div>
			<!-- Student Information -->
			<div class="panel-body">
				<table class="table table-bordered" id="mpTable">
					<thead>
						<th>Subject Code</th>
						<th>Description</th>
						<th>Actions</th>
                    </thead>
					<tbody>						
					<?php
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								$id = $row['SubjectKey'];
					?>
						<tr>
							<td><?php echo $row['SubjectCode'];?></td>
							<td><?php echo $row['SubjectDescription'];?></td>
							<td>
								<form method="post" action=<?php echo 'scripts/script-stgDelete.php?id='. $id . '&type=subjects'?>>
									<input class="btn btn-xs btn-danger" type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this?');" />
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

	<?php
		include("config.php");
		$sql = "select * from stg_Subject";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	?>
	<div class="col-lg-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Subject Configuration Manager</h3>
			</div>
			<div class="panel-body">
				<div class="col-lg-10 pull-right">
					<a class="btn btn-primary pull-right" href="studentDetails.php">Modify Subject</a>
				</div>

				<div>

				</div>
			</div>
			<!-- Student Information -->
			<div class="panel-body">
				<table class="table table-bordered" id="mpTable">
					<thead>
						<th>Code</th>
						<th>Subject Offer</th>
                    </thead>
					<tbody>						
					<?php
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								$id = $row['SubjectKey'];
					?>
						<tr>
							<td><?php echo $row['SubjectCode'];?></td>
							<td><?php echo $row['SubjectDescription'];?></td>
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