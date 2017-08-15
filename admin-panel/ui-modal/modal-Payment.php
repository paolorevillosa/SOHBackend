<?php
	$txtid = $_GET['txtId'];
	$txtName = $_GET['txtName'];
	$txtBalance = $_GET['txtBal'];
	$txtStudKey = $_GET['txtStudKey'];
?>
<form method="post" class="form-inline text-center">
	<table class="txtBalance borderless">
	<tr>
		<th><br>Finance Control Key &nbsp&nbsp&nbsp&nbsp</th>
		<td><br>
		<?php echo $txtid ?>
		</td>
	</tr>
	<tr>
		<th><br>Student No</th>
		<td><br><?php echo $txtStudKey ?></td>
	</tr>
	<tr>
		<th><br>Student Name</th>
		<td><br><?php echo $txtName ?></td>
	</tr>
	<tr>
		<th><br>Balance</th>
		<td><br><?php echo $txtBalance ?></td>
	</tr>
	<tr>
		<th><br>Amount to Pay</th>
		<td><br><input name="txtPayAmount" id="txtPayAmount" type="text" class="form-control" onkeyup="check(<?php echo $txtBalance?>)">
		<span id="error" class="hideDiv"><font color="red"><b>Invalid Input</b></font></span>
		</td>
	</tr>
	</table>
	<br>
	<input type="hidden" name="key" value="<?php echo $txtid ?>">
	<input type="hidden" name="StudKey" value="<?php echo $txtStudKey ?>">
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		<input type="submit" id="btnSub" value="Save" class="btn btn-default" name="btnSubmit" disabled>
	</div>
</form>


<script type="text/javascript">
	function check($initAmount){
		var val = $('#txtPayAmount').val();
		if($initAmount<val||isNaN(val)||val<500){
			$('#error').show();
			$('#btnSub').attr('disabled',true);
		}
		else{
			$('#error').hide();
			$('#btnSub').attr('disabled',false);
		}
	}
</script>
