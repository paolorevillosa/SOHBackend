<?php include("config.php"); ?>
<?php
	
	if(isset($_POST['btnSubmit'])){
	$data=array();
		for($x=1;$x<=7;$x++){
			$bin = explode(':', $_POST['SUBJECT'.$x]);
			$secData1 ='';
			$secData2 ='';
			$secData3 ='';
			if(($_POST['SUBJECT'.($x + 7)] != '0')){
				$bin2 = explode(':', $_POST['SUBJECT'.($x+7)]);
				$secData1 = "X".$bin2[0];
				$secData2 = " and ".$bin2[1];
				$secData3 = ',' . $bin2[2];
			}
			$data[] = array($bin[0] . $secData1 ,$bin[1] . $secData2,$bin[2] . $secData3);
		}
		$sql = "DELETE FROM stg_Subject";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		for($z=0;$z<count($data);$z++){
			$arrayData = $data[$z];
			$sql = "INSERT INTO stg_Subject VALUES (null,'".$arrayData[0] . "','".$arrayData[1] . "','" . $arrayData[2] . "',1)";
			$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		}
		header("location:dashboard.php");	
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
        <form method="post">
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
								$result2 = mysqli_query($conn,$sql) or die(mysqli_error($conn));

								while($row = mysqli_fetch_assoc($result2)){
									echo "<select name=SUBJECT". $subjectIden ." class='form-control'>";
									echo "<option value='0'></option>";
									$dataToEx = explode(" and ", $row['SubjectDescription']);
									foreach ($allSubject as $subjectSub) {
										//echo $subjectSub['SubjectCode'] ;
										$isSelected="";

										if($subjectSub['SubjectDescription'] == $dataToEx[0]||strtolower($subjectSub['SubjectCode']) == strtolower($dataToEx[0])){
											$isSelected="selected";
										}
										echo "<option  value='". $subjectSub['SubjectCode'] .":". $subjectSub['SubjectDescription'] .":". $subjectSub['SubjectDescKey'] ."' " . $isSelected . ">" . $subjectSub['SubjectDescription'] . "</option>";
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
									echo "<option value='0'></option>";
									foreach ($allSubject as $subjectSub) {
										$isSelected="";
										if(sizeof($dataToEx)>1 && (strtolower($subjectSub['SubjectCode']) == strtolower($dataToEx[1]))){
											$isSelected="selected";
										}
										echo "<option  value='". $subjectSub['SubjectCode'] .":". $subjectSub['SubjectDescription'] .":". $subjectSub['SubjectDescKey'] ."' " . $isSelected . ">" . $subjectSub['SubjectDescription'] . "</option>";
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
				<input type="submit" class="btn btn-primary" value="Update" name="btnSubmit">
			</div>
		</form>
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>