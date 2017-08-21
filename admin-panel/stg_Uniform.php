<?php
	$sql = "select * from stg_uniform";
	//$rowInf = mysqli_fetch_array();
	$result =  exexSQLget($sql);
	if(mysqli_num_rows($result)){
?>
	<table class="table table-bordered table-responsive">
		<thead>
			<tr>
				<th>Type</th>
				<th>Size</th>
				<th>Price</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = mysqli_fetch_assoc($result)){ ?>
			<tr>
				<?php $id = $row['UniformKey']; ?>
				<td><?php echo $row['UniformName'] ?></td>
				<td><?php echo $row['UniformSize'] ?></td>
				<td><?php echo $row['UniformPrice'] ?></td>
				<td>
					<form method="post" action=<?php echo 'scripts/script-stgDelete.php?id='. $id . '&type=uniform'?> >
						<input class="btn btn-xs btn-danger" type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete this?');" />
						<button id="btnUpdateUnif" class="btn btn-primary btn-xs" onclick="modOnClickUnif(<?php echo $id; ?>)">Update</button>
					</form>
				</td>
			</tr>
		<?php }?>
		</tbody>
	</table>
<?php } ?>

<div class="modal fade" id="modalUnif" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Book Information</h4>
            </div>
            <div id="modalContent-Unif">
            	<!--
            		Space for form supplied by the ajax output
            		-from scripts/script-getBookModal.php
            	-->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	function modOnClickUnif($id){
		$.ajax({
			url: "scripts/script-getUniformModal.php",
			data: {id:$id},
			type: "GET",
			datatype: "html",
			success: function(result){
				$("#modalContent-Unif").html();
				$("#modalContent-Unif").html(result);
				$("#modalUnif").modal();
			}
		})
	}

	$(document).keyup(function(e) {
	  //if (e.keyCode === 13) $('.save').click();     // enter
	  if (e.keyCode === 27) {	
	  		$("#modalUnif").modal('hide');	
	  }
	});

	$('button[id="btnUpdateUnif"]').on("click",function(evt){
		evt.preventDefault();
	});

</script>