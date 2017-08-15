<div id="wrapper">
<?php
	include("ui-navigation.php");
	include("config.php");
	$cnt = count($_GET);
	$row = "";
	$title = "Register New Teacher";
	$iden2 = "btnSave";
	$id="";
	if($cnt>0){
		$title = "Teacher Information";
		$iden2 = "btnUpdate";
		$id = $_GET['key'];
		$sql = "select * from stg_teacher where TeacherKey = '$id'";
		$result = mysqli_query($conn,$sql)or die (mysqli_error($conn));
		$row = mysqli_fetch_array($result);
	}
?>
<!-- Main Content of the Page :: KPR-->
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					<?php echo $title; ?>
                </h1>
            </div>
        </div>
		<div class="row">
			<div>
				<form method="post" action="script-teacher.php?x=<?php echo $id; ?>">
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Teacher No</label>
							<div class="col-sm-10">
								<p class="form-control-static"><strong><?php echo getData("TeacherNo",$row);?></strong></p>
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Name" name="txtLName" value="<?php echo getData("LastName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Name" name="txtFName" value="<?php echo getData("FirstName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Middle Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Name" name="txtMName" value="<?php echo getData("MiddleName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Contact #</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Name" name="txtCont" value="<?php echo getData("ContactNo",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Birthdate</label>
							<div class="col-sm-10">
								<div class="col-sm-3">
									<label for="inputEmail3" class="col-sm-3 control-label">Month</label>
									<select class="form-control" name="txtMonth">
									<?php
										gntCmb(date('m', strtotime(getData("DOB",$row))),13,false);
									?>
									</select>
								</div>
								
								<div class="col-sm-3">
									<label for="inputEmail3" class="col-sm-3 control-label">Day</label>
									<select class="form-control" name="txtDay">
									<?php
										gntCmb(date('d', strtotime(getData("DOB",$row))),31,false);
									?>
									</select>
								</div>
								
								<div class="col-sm-3">
									<label for="inputEmail3" class="col-sm-3 control-label">Year</label>
									<select class="form-control" name="txtYear">
									<?php
										gntCmb(date('Y', strtotime(getData("DOB",$row))),date("Y") - 6,true);
									?>
									</select>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Address</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Name" name="txtAdd" value="<?php echo getData("Address",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Year Level</label>
							<div class="col-sm-4">
								<select name="txtYearLevelKey" class="form-control">
								<option value=""></option>
								<?php
									for($x=1;$x<=4;$x++){
										if(getData("YearLevelKey",$row)==$x){
											echo "<option name='$x' selected>$x</option>";
										}
										else{
											echo "<option name='$x'>$x</option>";
										}
									}
								?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Subject</label>
							<div class="col-sm-4">
								<select name="sbjCode" class="form-control">
								<option value=""></option>
								<?php
									$sqlSbj = "select * from stg_SubjectDesc";
									$res = mysqli_query($conn,$sqlSbj) or die(mysqli_error($conn));
									while($data = mysqli_fetch_array($res)){
										if(getData("SubjectDescKey",$row)==$data['SubjectDescKey']){
											echo "<option value='". $data['SubjectDescKey'] ."' selected>". $data['SubjectDescription'] ."</option>";
										}
										else{
											echo "<option value='". $data['SubjectDescKey'] ."'>". $data['SubjectDescription'] ."</option>";
										}
									}
								?>
								</select>
							</div>
						</div>
					</div>

					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Subject</label>
							<div class="col-sm-4">
								<select name="CivilStatus" class="form-control">
								<option value=""></option>
								<?php
									$sqlSbj = "select * from istg_CivilStatus";
									$res = mysqli_query($conn,$sqlSbj) or die(mysqli_error($conn));
									while($data = mysqli_fetch_array($res)){
										if(getData("CivilStatusKey",$row)==$data['CivilStatusKey']){
											echo "<option value='". $data['CivilStatusKey'] ."' selected>". $data['Status'] ."</option>";
										}
										else{
											echo "<option value='". $data['CivilStatusKey'] ."'>". $data['Status'] ."</option>";
										}
									}
								?>
								</select>
							</div>
						</div>
					</div>
					
					
					
					<div class="form-group col-lg-12">
						<div class="modal-footer">	
							<a href="teacher.php" type="button" class="btn btn-default">Cancel</a>
							<button type="submit" class="btn btn-default" name="<?php echo $iden2; ?>">SAVE</button>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>