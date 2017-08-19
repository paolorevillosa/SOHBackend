<?php
	include("../scripts/script-complete.php");
	$sql = "SELECT a.StudentKey,a.LastName,a.FirstName,a.MiddleName,b.Status 
			FROM stud_student a
			LEFT JOIN stud_grade b
			ON a.StudentKey = b.StudentKey
			WHERE isActive = '0'";
	$result = (customCrudSQL($sql,"../config.php"));



?>

<table class="table">
	<thead>
	<?php if(mysqli_num_rows($result) > 0){ ?>
		<tr>
			<th>#</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$count = 1;
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['StudentKey'];
		?>
			<tr>
				<td><?php echo $count?></td>
				<td><?php echo $row['LastName']?></td>
				<td><?php echo $row['FirstName']?></td>
				<td><?php echo $row['MiddleName']?></td>
				<td><?php echo $row['Status']?></td>
				<td>
					<a href="<?php echo 'studentDetails.php?key='. $id ?>" class="btn btn-xs btn-primary">Enroll Student</a>
					<!--<button id="btnEnrollStud" onclick="modOnClick()" class="btn-xs btn-primary btn">Enroll Student</button>-->

				</td>
			</tr>
		<?php
			$count++;
			}
		}
		else{
		?>
		<th class="text-center">NO RECORD FOUND</th>
		<?php } ?>
	</tbody>	
</table>

<script type="text/javascript">
	/*function modOnClick(){
		$.ajax({
			url: "./studentDetails.php",
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
	});*/

	
</script>