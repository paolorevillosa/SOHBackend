<?php
	if(isset($_POST['btnSubmitNotif'])){
		
		$title = $_POST['txtTitle'];
		$Message = $_POST['txtMessage'];
		$PostUntil = $_POST['PostUntil'];
		$newDate = date("Y-m-d", strtotime($PostUntil));
		include("config.php");
		$sql = "INSERT INTO stud_notification_v2(StudentKey,NotificationTitle,NotificationMessage,DatePosted,PostUntil)
				SELECT c.StudentKey,(SELECT '$title'),(SELECT '$Message'),(SELECT curdate()),(SELECT '$newDate')
				FROM   school_finance a
				LEFT JOIN school_finance_details B
				ON A.FinanceKey = B.FinanceKey
				LEFT JOIN stud_student c
				ON c.StudentKey  = a.StudentKey
				GROUP  BY a.FinanceKey,a.TuitionFee
				HAVING a.TuitionFee - IFNULL((SUM(CASE WHEN B.Amount = NULL THEN '0' ELSE B.Amount END)),0) > 0
				ORDER  BY a.FinanceKey";
		$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));		
	}

?>
<?php
	if(isset($_POST['btnSubmit'])){
		$txtAmount = $_POST['txtPayAmount'];
		$txtFinKey = $_POST['key'];
		$txtStudKey = $_POST['StudKey'];
		$date = date("Y-m-d");
		$sql = "INSERT INTO school_finance_details VALUES (null,$txtFinKey,'$date',$txtAmount)";
		include("config.php");
		$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
		$sql = "UPDATE school_enrollee SET Status = 1 WHERE StudentKey = $txtStudKey";
		$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	}

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
					Student Financial Account
                </h1>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>List of Students</h3>
					</div>
					<div class="panel-body">
						<div class="col-lg-10">
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
							</form>
						</div>
						<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNotif">
										  Send Notification</button>
					</div>
					<!-- SchedInfo Information -->
					<div class="panel-body">
						<div id="loading" class="hideDiv"><center><img src="../img/progress.gif"></center></div>
						<div id="tblContent">

						</div>
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

       $(document).on('change','#section',function(){
       		var val = $(this).val();
       		var yearLevel = $('#yearLevel').val();
       		$('#tblContent').hide();
       		$('#loading').show();
       		$.ajax({
       			url:"scripts/script-getFinancial.php",
       			data:{section:val,yearLevel:yearLevel},
       			type:'GET',
       			dataType:'html',
       			success: function(res){
       				window.setTimeout(function(){
	       				$('#tblContent').html();  
	                    $('#tblContent').html(res); 
	                    $('#tblContent').show();
	                    $('#loading').hide();
	                }, 1000);
       			}
       		})
       });
  </script>

  <!-- Modal -->
<div class="modal fade" id="modalNotif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Notification For Unpaid Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
     	<div class="form-group row">
	      <label for="txtSInfo1" class="col-sm-2 col-form-label">Title</label>
	      <div class="col-sm-7">
	        <input type="text" class="form-control" id="txtSInfo1" placeholder="Title" name="txtTitle" value="Finance Update">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo3" class="col-sm-2 col-form-label">Message</label>
	      <div class="col-sm-7">
	        <textarea class="form-control" id="txtSInfo3" placeholder="Message" name="txtMessage" value="">You have a pending account to school finance, please settle your account as soon as possible</textarea>
	      </div>
	    </div>
	    <div class="form-group row">
	      <label for="txtSInfo3" class="col-sm-2 col-form-label">Post Until</label>
	      <div class="col-sm-7">
	      	<input type="date" class="form-control" name="PostUntil">
	      </div>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="btnSubmitNotif" class="btn btn-primary" value="Send Notification"></button>
      </div>
      </form>
    </div>
  </div>
</div>