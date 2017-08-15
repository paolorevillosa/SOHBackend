<div id="wrapper">
<?php
	include("ui-navigation.php");
	$cnt = count($_GET);
	$row = "";
	$title = "Register New Student";
	$iden2 = "btnSave";
	$id="";
	if($cnt>0){
		$title = "Student Information";
		$iden2 = "btnUpdate";
		$id = $_GET['key'];
		$sql = "call sp_getStudent($id)";
		include("config.php");
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
				<form method="post" action="script-student.php?x=<?php echo $id; ?>">
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Student No</label>
							<div class="col-sm-10">
								<p class="form-control-static"><strong><?php echo getData("StudentNo",$row);?></strong></p>
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Last Name" name="txtLName" value="<?php echo getData("LastName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="First Name" name="txtFName" value="<?php echo getData("FirstName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Middle Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Middle Name" name="txtMName" value="<?php echo getData("MiddleName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Contact #</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Contact #" name="txtCont" value="<?php echo getData("ContactNo",$row);?>">
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
								<input type="text" class="form-control" id="inputName" placeholder="Address" name="txtAdd" value="<?php echo getData("Address",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Guardian</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Guardian Name" name="txtGrdn" value="<?php echo getData("GuardianName",$row);?>">
							</div>
						</div>
					</div>
					
					<div class="row form-horizontal col-lg-12">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Gender</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputName" placeholder="Gender" name="txtGender" value="<?php echo getData("Gender",$row);?>">
							</div>
						</div>
					</div>
					
					
					
					<div class="form-group col-lg-12">
						<div class="modal-footer">	
							<a href="student.php" type="button" class="btn btn-default">Cancel</a>
							<button type="submit" class="btn btn-default" name="btnOffialEnroll">SAVE</button>
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