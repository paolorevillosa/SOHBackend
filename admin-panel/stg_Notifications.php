<?php include("config.php"); ?>

<table class="table table-bordered">
	<tbody>
		<tr>
			<td>Enrollment</td>
		<!--<form method="post">-->
		<?php
			if(isset($_GET['btnA'])){
				$sql = "UPDATE school_enrollment_period SET dateCreated=curdate(), isEnrollemt = 1";
				$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
				echo '<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Maintenance successfully Deployed</div>';
			}
			if(isset($_POST['btnI'])){
				$sql = "update school_enrollment_period set dateCreated=curdate(), isEnrollemt = 0";
				$result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));
				echo '<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Maintenance successfully Closed
				</div>';
			}

			//<?php
				
				$sql = "select * from school_enrollment_period";
				$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$row = mysqli_fetch_assoc($result);
			
			if($row['isEnrollemt']==0){
				echo '<td><button type="submit" class="btn btn-primary" name="btnA" data-toggle="modal" data-target="#myModal-forEnrollment">Open Enrollment</button></td>';
			}
			else{
				echo "<form method='post'>";
				echo '<td><button type="submit" class="btn btn-danger" name="btnI">Disable Enrollment</button></td>';
				echo "</form>";
			}
		?>
		

		</tr>
		<tr>
			<td>Date Posted</td>
			<?php
				echo "<td>" . $row["dateCreated"] . "</td>";
			?>
		</tr>
		<tr>
			<td>End Date</td>
			<td><input type="date" class="form-control" id="datePicker"
			<?php
				if($row['isEnrollemt']==1){
					echo " disabled";	
				}
			?>
			></td>
		</tr>
		<!--</form>-->
	</tbody>
</table>

<br/><br/><br/>

<h4>Send Message to All Students</h4>
<form method="post">
	<div id="schoolInfo">
		<div class="form-group row">
	      <label for="txtSInfo1" class="col-sm-2 col-form-label">Title</label>
	      <div class="col-sm-7">
	        <input type="text" class="form-control" id="txtSInfo1" placeholder="Title" name="txtTitle">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo3" class="col-sm-2 col-form-label">Message</label>
	      <div class="col-sm-7">
	        <textarea class="form-control" id="txtSInfo3" placeholder="Message" name="txtMessage"></textarea>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo3" class="col-sm-2 col-form-label">Post Until</label>
	      <div class="col-sm-7">
	        <input type="date" name="dateUntil" class="form-control">
	      </div>
	    </div>


	    <input type="submit" value="Save" name = "btnSubmitNotif" class="btn btn-primary col-sm-push-2 col-sm-7">
	</div>
</form>

<?php
	if(isset($_POST['btnSubmitNotif'])){
		$title = $_POST['txtTitle'];
		$Message = $_POST['txtMessage'];
		$dateUntil = $_POST['dateUntil'];
		/*$sql = "INSERT INTO stud_notification(NotificationTitle,NotificationMessage,DatePosted)
				SELECT StudentKey,(select '$title'),(select '$Message'),curdate()
				FROM school_enrollee 
				WHERE SchoolYear = '2017-2018'";*/
		$sql = "INSERT INTO stud_notification values (null,'$title','$Message',curdate(),'$dateUntil')";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));	
		echo "OK";
	}
?>

<!--modal-->
<div class="modal fade" id="myModal-forEnrollment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Book Information</h4>
            </div>
            <div id="modalContent-Enrollment">
            	You are about to open the system for enrollment<br>
            	Do you want to generate a new schedule?
            </div>
            <div class="modal-footer">
            	<form method="post"  action="testScheduling.php">
					<input type="submit" class="btn btn-default" value="Yes" name="btnYes">
					<input type="submit" class="btn btn-default" value="No" name="btnNo">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</form>
			</div>
        </div>
    </div>
</div>