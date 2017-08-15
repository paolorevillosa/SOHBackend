<?php   

 include "../config.php";
 	$sectionKey = $_GET['section'];
 	$yearLevel = $_GET['yearLevel'];
	$sql = "SELECT a.StudentKey,concat(a.LastName,', ',a.FirstName,' ',a.MiddleName) AS Name,a.StudentNo
			,b.TuitionFee,b.FinanceKey
			FROM school_enrollee c 
			LEFT JOIN stud_student a
			ON c.StudentKey = a.StudentKey
			LEFT JOIN school_finance b
			ON b.EnrolleeKey = c.EnrolleeKey
			WHERE c.StudentGroupKey = $sectionKey AND c.YearLevelKey = $yearLevel
			";
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		echo '<table class="table table-border">
				<thead>
					<tr>
						<th>Student #</th>
						<th>Name</th>
						<th>Balance</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';
		while($row = mysqli_fetch_assoc($result)){
				$studKey = $row['StudentKey'];
				$key = $row['FinanceKey'];
				$sql2 = "SELECT SUM(Amount) as paid FROM school_finance_details WHERE FinanceKey = '$key'";
				$result2 = mysqli_query($conn,$sql2)or die(mysqli_error($conn));
				$paid;
				if(mysqli_num_rows($result2) > 0){
					$row2 = mysqli_fetch_assoc($result2);
					$paid = $row2['paid'];
				}
				$data = $studKey . "," . $key . "," . ($row["TuitionFee"] - $paid) . ",'" . $row['Name'] . "'";
				echo'	<tr>
						<td>' . $row["StudentNo"] . '</td>
						<td>' . $row["Name"] . '</td>
						<td>' . ($row["TuitionFee"] - $paid) . '</td>
						<td>';
				if(($row["TuitionFee"] - $paid)!=0){
					?>
						<button id="btnUpdate" class="btn-xs btn btn-primary" onclick="modOnClick(<?php echo  $data?>)">Add Payment</button>
					<?php
				}
				else{
					echo '<button id="btnUpdate" class="btn-xs btn btn-primary" disabled>Full Paid</button>';
				}
				
					echo	'</td>
					</tr>';
		}
		echo' 	</tbody>
			</table>';
	}
	else{
		echo '<table class="table table-border">
			<th class="text-center">NO RECORD FOUND</th>
			<table>';
	}

?>


<div class="modal fade" id="modalNewStud" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Payment</h4>
            </div>
            <div id="modalContent-NewStud">
            	<!--
            		Space for form supplied by the ajax output
            		-from scripts/script-getBookModal.php
            	-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function modOnClick($studKey,$id,$bal,$name){
		$.ajax({
			url: "ui-modal/modal-Payment.php",
			data: {txtId:$id,txtName:$name,txtBal:$bal,txtStudKey:$studKey},
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
