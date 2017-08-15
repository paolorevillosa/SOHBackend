<?php
	include("script-complete.php");
	$id = $_GET['id'];
	$sql = "select * from stg_uniform where UniformKey = $id";
	$row = "";
	if($id != 0){
		$row = mysqli_fetch_array(customSQL($sql,"../config.php"));
	}
	
?>
<form method="post">
	<div class="modal-body">
		<br>
		<div>
			<label for="txtUSize" class="col-sm-4 control-label">Uniform</label>
			<div>
				<input type="text" class="form-control" id="txtUSize" placeholder="Name" name="txtUnifName" value="<?php echo getInfo('UniformName',$row) ?>">
			</div>
		</div>
		<br>
		<div>
			<label for="txtPrice" class="col-sm-4 control-label">Size</label>
			<div>
				<input type="text" class="form-control" id="txtPrice" placeholder="Price" name="txtUnifSize" value="<?php echo getInfo('UniformSize',$row) ?>">
			</div>
		</div>
		<div>
			<label for="txtPrice" class="col-sm-4 control-label">Price</label>
			<div>
				<input type="text" class="form-control" id="txtPrice" placeholder="Price" name="txtUnifPrice" value="<?php echo getInfo('UniformPrice',$row) ?>">
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		<input type="submit" value="Save" class="btn btn-default" name="btnSubmit">
	</div>
</form>