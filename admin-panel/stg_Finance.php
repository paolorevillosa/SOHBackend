<?php
	if(isset($_POST['btnSubmitFin'])){
		$tAmount = $_POST['txtAmount'];
		$mAmount = $_POST['txtMisc'];
		$sqlUpdate = "UPDATE stg_tuitionfee SET TuitionAmount = '$tAmount', MiscelenousFee = '$mAmount'";
		$return = crudSQL($sqlUpdate);
	}

	$sql = "select * from stg_tuitionfee";
	$result  = exexSQLget($sql);
	$row = mysqli_fetch_assoc($result);
?>
<!--For Finance UI -->
<h4>Finance Settigs</h4>
<form method="post">
	<input id="txtAmount" name="txtAmount" type = "text" class="form-control" placeholder="Amount" value="<?php echo $row['TuitionAmount'] ?>" disabled>
	<br>
	<input id="txtMisc" type="text" name="txtMisc" class="form-control" placeholder="Miscellaneous" value="<?php echo $row['MiscelenousFee'] ?>" disabled>

	<br>
	<div class="pull-right">
		<input id="btnSubmitFin" name="btnSubmitFin" type="submit" value="Save" class="btn btn-primary" disabled>
		<button id="btnUpdateFin" value="Update" class="btn btn-primary">Update</button>
	</div>
</form>	

<script type="text/javascript">
	$('button[id="btnUpdateFin"]').on("click",function(evt){
		evt.preventDefault();
		if($("#btnUpdateFin").text()=="Update"){
			$("#btnUpdateFin").text("Cancel");
			enableDisable(false);
		}
		else{
			enableDisable(true);
			$("#btnUpdateFin").text("Update");
		}
	});

	function enableDisable(_x){
		$("#txtAmount").prop("disabled",_x);
		$("#txtMisc").prop("disabled",_x);
		$("#btnSubmitFin").prop("disabled",_x);
	}

</script>

