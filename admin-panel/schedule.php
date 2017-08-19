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
					Student Information
                </h1>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Schedule Information Module</h3>
					</div>
					<div class="panel-body">
						<div class="col-lg-10 pull-right">
							<form method="post">
								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Year Level</label>
									<div class="col-sm-3">
										<select name="yearLevel" id="yearLevel" class = "form-control">
											<option value="0"></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Section</label>
									<div class="col-sm-3">
										<select name="section" id="section" class = "form-control">
											
										</select>
									</div>
								</div>

								<button type="submit" name="btnSearchInfo" class="btn btn-primary pull-right" value="Search">Search</button>
							</form>
						</div>
					</div>
					<!-- SchedInfo Information -->
					<div class="panel-body">
						<?php 
							if(isset($_POST['btnSearchInfo'])){
								include("config.php");
								$id="";
								if(!empty($_POST['yearLevel'])){
									$id = $_POST['section'];	
								}
								$sql = "call sp_getSchedule('$id')";
								$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
						?>
						<table class="table">
							<?php
								if(mysqli_num_rows($result) > 0){
									$row = mysqli_fetch_assoc($result);
							?>
							<tr>
								<table class="table">
									<tbody>
										<td>Year Level : <?php echo $_POST['yearLevel']?></td>
										<td class="text-right">Section :	<?php echo $row['StudentGroupName']?></td>
									</tbody>
		                        </table>
							</tr>
							<tr>
								<table class="table table-bordered">
									<thead>
										<th>Subject</th>
										<th>Time</th>
										<th>Teacher</th>
										<!--<th>Actions</th>-->
		                            </thead>
									<tbody>
										
											<?php
													while($row = mysqli_fetch_assoc($result)){
														$id = $row['ScheduleKey'];
											?>
											<tr>
											<td><?php echo $row['SubjectDescription'];?></td>
											<td><?php echo $row['Details'];?></td>
											<td><?php echo $row['LastName'];;?></td>
											<!--<td>
												<form method="post" action=<?php echo 'script-delete-student.php?x='. $id?>>
													<a class="btn btn-primary" href="<?php echo 'studentDetails.php?key='.$id?>">Update</a>
													<input class="btn btn-danger" type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this?');" />
												</form>
											</td>-->
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
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>

<script type="text/javascript">
       $(document).on('change','#yearLevel',function(){
             var val = $(this).val();
             $.ajax({
                   url: "scripts/script-getSections.php",
                   data: {yearLevel:val},
                   type: 'GET',
                   dataType: 'html',
                   success: function(result){
                        $('#section').html();  
                        $('#section').html(result); 
                   }
              });
       });
  </script>