<?php
	include("config.php");
	if(isset($_POST['btnSubmitBook'])){
		$txtBookCode = $_POST['txtBookCode'];
		$txtBookName = $_POST['txtBookName'];
		$txtBookPrice = $_POST['txtBookPrice'];
		$txtYearLevelKey = $_POST['txtYearLevelKey'];
		$isUpdate = $_POST['isUpdate'];

		$sql = "INSERT into stg_books values(null,'$txtBookCode','$txtBookName','$txtBookPrice','$txtYearLevelKey')";
		if($isUpdate=="1"){
			$sql = "UPDATE stg_books SET BookName = '$txtBookName',BookPrice='$txtBookPrice',YearLevelKey = '$txtYearLevelKey' WHERE BookCode = '$txtBookCode'";
		}
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));	
	}
	$sql = "select * from stg_books";
	$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
?>

<button class="btn btn-primary pull-right" onclick="modOnClickBooks(0)">Add New Book</button>
<br/><br/>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Book Code</th>
			<th>Description</th>
			<th>Price</th>
			<th>Year Level</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if(mysqli_num_rows($result)){
			while($row = mysqli_fetch_assoc($result)){
				$id =  $row['BookKey'];
			?>
		<tr>
			<td><?php echo $row['BookCode'];?></td>
			<td><?php echo $row['BookName'];?></td>
			<td><?php echo $row['BookPrice'];?></td>
			<td><?php echo $row['YearLevelKey'];?></td>
			<td>
				<div>
				<form method="post" action=<?php echo 'scripts/script-stgDelete.php?id='. $id . '&type=books'?> >
					<input class="btn btn-xs btn-danger" type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this?');" />
					<button id="btnUpdateBook" class="btn-xs btn btn-primary" onclick="modOnClickBooks(<?php echo $id; ?>)">Update</button>
				</form>
					
				</div>
			</td>
		</tr>
	<?php
			}
		}
	?>
	</tbody>
</table>

<!--modal-->
<div class="modal fade" id="modalBooks" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Book Information</h4>
            </div>
            <div id="modalContent-Books">
            	<!--
            		Space for form supplied by the ajax output
            		-from scripts/script-getBookModal.php
            	-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	function modOnClickBooks($id){
		$.ajax({
			url: "scripts/script-getBookModal.php",
			data: {id:$id},
			type: "GET",
			datatype: "html",
			success: function(result){
				$("#modalContent-Books").html();
				$("#modalContent-Books").html(result);
				$("#modalBooks").modal();
			}
		})
	}

	$(document).keyup(function(e) {
	  //if (e.keyCode === 13) $('.save').click();     // enter
	  if (e.keyCode === 27) {	
	  		$("#modalBooks").modal('hide');	
	  }
	});

	$('button[id="btnUpdateBook"]').on("click",function(evt){
		evt.preventDefault();
	});

</script>