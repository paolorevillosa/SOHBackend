<?php

	include("script-complete.php");
	$id = $_GET['id'];
	$sql = "select * from stg_books where BookKey = $id";
	$row = "";
	if($id != 0){
		$row = mysqli_fetch_array(customSQL($sql,"../config.php"));
	}
	
?>
<form method="post">
	<div class="modal-body">
		<div>
			<label for="txtUName" class="col-sm-4 control-label">Book Code</label>
			<div>
				<input type="text" class="form-control" id="txtUName" placeholder="Code" name="txtBookCode" value="<?php echo getInfo('BookCode',$row) ?>"/>
			</div>
		</div>
		<br>
		<div>
			<label for="txtUSize" class="col-sm-4 control-label">Book Name</label>
			<div>
				<input type="text" class="form-control" id="txtUSize" placeholder="Name" name="txtBookName" value="<?php echo getInfo('BookName',$row) ?>">
			</div>
		</div>
		<br>
		<div>
			<label for="txtPrice" class="col-sm-4 control-label">Price</label>
			<div>
				<input type="text" class="form-control" id="txtPrice" placeholder="Price" name="txtBookPrice" value="<?php echo getInfo('BookPrice',$row) ?>">
			</div>
		</div>
		<div>
			<label for="txtPrice" class="col-sm-4 control-label">Year Level</label>
			<div>
				<select name="txtYearLevelKey" class="form-control">
					<option value=""></option>
					<?php
						for($x=1;$x<=4;$x++){
							if(getData("YearLevelKey",$row)==$x){
								echo "<option name='$x' selected>$x</option>";
							}
							else{
								echo "<option name='$x'>$x</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		<input type="submit" value="Save" class="btn btn-default" name="btnSubmitBook">
	</div>
</form>