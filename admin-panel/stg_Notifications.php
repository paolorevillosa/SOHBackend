<?php include("config.php"); ?>

<table class="table table-bordered">
	<tbody>
		<tr>
			<td>Enrollment</td>
		<form method="post">
		<?php
			if(isset($_POST['btnA'])){
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
				echo '<td><button type="submit" class="btn btn-primary" name="btnA">Open Enrollment</button></td>';
			}
			else{
				echo '<td><button type="submit" class="btn btn-danger" name="btnI">Disable Enrollment</button></td>';
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
		</form>
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


	    <input type="submit" value="Save" name = "btnSubmitNotif" class="btn btn-primary col-sm-push-2 col-sm-7">
	</div>
</form>

<?php
	if(isset($_POST['btnSubmitNotif'])){
		$title = $_POST['txtTitle'];
		$Message = $_POST['txtMessage'];
		/*$sql = "INSERT INTO stud_notification_v2 (StudentKey,NotificationTitle,NotificationMessage,DatePosted)
				SELECT StudentKey,(select '$title'),(select '$Message'),curdate()
				FROM school_enrollee 
				WHERE SchoolYear = '2017-2018'";*/
		$sql = "";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));	
		echo "OK";
	}
?>