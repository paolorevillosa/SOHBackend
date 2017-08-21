<?php include("config.php"); ?>
<?php
	//update table tblsubject
	if(isset($_POST['btnSubmit'])){
		//if()


	}
?>
<div class="row">
	<?php
		$sql = "select * from stg_SubjectDesc";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	?>
	<div id="wrapper">
<?php
	include("ui-navigation.php");
?>
<!-- Main Content of the Page :: KPR-->
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Modify Subject
                </h1>
            </div>
        </div>
        <form action="post">
        <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="lagyan1" class="col-lg-6">
							<?php 
							$subjectIden = 1;
							if(mysqli_num_rows($result) > 0){ 
								while($row = mysqli_fetch_assoc($result)){
									$allSubject[] = $row;
							 	}
							 }
								$sql = "select * from stg_Subject";
								$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

								while($row = mysqli_fetch_assoc($result)){
									echo "<select name=SUBJECT". $subjectIden ." class='form-control'>";
									echo "<option></option>";
									$dataToEx = explode(" and ", $row['SubjectDescription']);
									foreach ($allSubject as $subjectSub) {
										//echo $subjectSub['SubjectCode'] ;
										$isSelected="";
										if($subjectSub['SubjectDescription'] == $dataToEx[0]||strtolower($subjectSub['SubjectCode']) == strtolower($dataToEx[0])){
											$isSelected="selected";
										}
										echo "<option  value='". $subjectSub['SubjectCode'] ."' " . $isSelected . ">" . $subjectSub['SubjectDescription'] . "</option>";
									}
									echo "<select>";
									$subjectIden++;
								}

							?>
						</div>

						<div id="lagyan2" class="col-lg-6">
							<?php
								$sql = "select * from stg_Subject";
								$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
								while($row = mysqli_fetch_assoc($result)){
									$dataToEx = explode("X", $row['SubjectCode']);
									echo "<select name=SUBJECT". $subjectIden ." class='form-control'>";
									echo "<option></option>";
									foreach ($allSubject as $subjectSub) {
										$isSelected="";
										if(sizeof($dataToEx)>1 && (strtolower($subjectSub['SubjectCode']) == strtolower($dataToEx[1]))){
											$isSelected="selected";
										}
										echo "<option " . $isSelected . ">" . $subjectSub['SubjectDescription'] . "</option>";
									}
									echo "<select>";
									$subjectIden++;
								}
							?>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="pull-right">
				<input type="button" class="btn btn-primary" value="Update" name="btnSubmit">
			</div>
		</form>		
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>