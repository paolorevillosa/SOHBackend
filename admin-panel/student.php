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
		<?php
			include("config.php");
			$sql = "select * from vw_studinfo";
			$dataSearch = -1;
			//$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(isset($_POST['btnSearch'])){
				$dataSearch = $_POST['selectOption'];
				if($dataSearch==0){
					$sql = "SELECT * from vw_studinfo";
				}
				else if($dataSearch==1){
					$sql = "SELECT * FROM vw_enrolled";
				}
				else if($dataSearch==2){
					$sql = "SELECT * FROM vw_preenrolled";
				}
			}
			$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>List of Student</h3>
					</div>
					<div class="panel-body">
						<h4>Filter</h4>
						<button id="btnUpdate" class="btn btn-primary" onclick="modOnClick()">Show Incoming Students</button>
						<span class="form-group">
							<form method="post">
								<div class="col-lg-6 pull-right">
										<select class="form-control" name="selectOption">
											<option value="-1"></option>
											<option value="0">All Students</option>
											<option value="1">Enrolled Students</option>
											<option value="2">Pre-Enrolled Students</option>
										</select>
										<input type="submit" class="btn btn-primary" value="Search" name="btnSearch">
								</div>

							</form>
						</span>
					</div>
					<div class="panel-body">
						<table class="table table-bordered table-responsive" id="mpTable">
							<thead>
								<th>Student No.</th>
								<th>Name</th>
								<?php if($dataSearch>=1){ echo "<th>Year Level</th>
								<th>Status</th>"; } ?>
								<th>Actions</th>
                            </thead>
							<tbody>
								
									<?php
										if(mysqli_num_rows($result) > 0){
											while($row = mysqli_fetch_assoc($result)){
												if($dataSearch>=1){
													if($dataSearch==1){
														$yearLevel = $row['YearLevelKey'];
														$enrollStatus = "Enrolled";
													}
													else{
														$yearLevel = $row['YearLevelKey'];
														$enrollStatus = "Pending";
													}
												}
												$id = $row['StudentKey'];
									?>
									<tr>
									<td><?php echo $row['StudentNo'];?></td>
									<td><?php echo $row['FullName'];?></td>
									<?php if($dataSearch>=1){ echo "<td>".$yearLevel."</td>
									<td>".$enrollStatus."</td>"; } ?>
									<td>
										<form method="post" action=<?php echo 'script-delete.php?id='. $id . "&type=student&loc=" . $_SERVER['REQUEST_URI']?>>
											<a class="btn btn-primary btn-xs" href="<?php echo 'studentDetails.php?key='.$id?>">Update</a>
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


<div class="modal fade" id="modalNewStud" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Incoming Students</h4>
            </div>
            <div id="modalContent-NewStud">
            	<!--
            		Space for form supplied by the ajax output
            		-from scripts/script-getBookModal.php
            	-->
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
			</div>
        </div>
    </div>
</div>


<script type="text/javascript">
	function modOnClick(){
		$.ajax({
			url: "ui-modal/modal-IncomingStudents.php",
			datatype: "html",
			success: function(result){
				$("#modalContent-NewStud").html();
				$("#modalContent-NewStud").html(result);
				$("#modalNewStud").modal();
			}
		})
	}
	$(document).keyup(function(e) {
	  //if (e.keyCode === 13) $('.save').click();     // enter
	  if (e.keyCode === 27) {	
	  		$("#modalNewStud").modal('hide');	
	  }
	});

	
</script>