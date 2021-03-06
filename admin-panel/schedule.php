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
								//$sql = "call sp_getScheduleV2('$id')";
								$sql = "SELECT a.ScheduleKey,a.StudentGroupKey,b.StudentGroupName,
												a.SubjectKey,a.TeacherKey,c.LastName,a.TimeKey,
												IFNULL(e.SubjectDescription,'BREAK') as SubjectDescription,d.Details
												From school_schedule a
												LEFT JOIN stud_studentgroup b
												ON a.StudentGroupKey = b.StudentGroupKey
												LEFT JOIN stg_teacher c
												ON a.TeacherKey = c.TeacherKey
												LEFT JOIN stg_time d
												ON d.TimeKey = a.TimeKey
												LEFT JOIN stg_subject e
												ON e.SubjectKey = a.SubjectKey
												WHERE a.StudentGroupKey = $id";
								$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
						?>
						<table class="table">
							<?php
								echo mysqli_num_rows($result);
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
										<th>Time</th>
										<th>Subject</th>
										<th>Teacher</th>
										<!--<th>Actions</th>-->
		                            </thead>
									<tbody>
										
											<?php
												$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
													while($row = mysqli_fetch_assoc($result)){
														$id = $row['ScheduleKey'];
											?>
											<tr>
											<td><?php echo $row['Details'];?></td>
											<td><?php echo $row['SubjectDescription'];?></td>
											<td><?php echo /*$row['LastName'];*/getTeacher($row['TeacherKey']);?></td>
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


<?php
  		//get teacher for multpiple teacher
  	function getTeacher($id){
    	$teacherName = '';
      	$ids = explode(",", $id);
      	for($x=0;$x<sizeof($ids);$x++){
        	if($ids[$x] == ""){
          		continue;
        	}
	        include("config.php");
	        $sql = "SELECT * from stg_teacher where TeacherKey = " . $ids[$x];
	        $result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));  
	        $row = mysqli_fetch_assoc($result);
	        if($x>0){
	          $teacherName = $teacherName . "<br>" . $row['LastName'];  
	        }
	        else{
	          $teacherName .= $row['LastName'];  
	        }
      	}
      return $teacherName;
    }
    function getSubject($sub){
    	$subjects = explode(" and ", $sub);
	    $subject = $subjects[0];
	    if(sizeof($subjects)!=1){
	    	$subject = $subjects[0] ."<br>" . $subjects[1];
	    }
	    return $subject;
    }
?>