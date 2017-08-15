<?php
	$sql = "select * from information";
	$rowInf = mysqli_fetch_array(exexSQLget($sql));
?>

<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
	<div id="schoolInfo">
		<div class="form-group row">
	      <label for="txtSInfo1" class="col-sm-2 col-form-label">School Name</label>
	      <div class="col-sm-7">
	        <input type="text" class="form-control" id="txtSInfo1" placeholder="School Name" name="txtSname" value="<?php echo $rowInf["SchoolName"] ?>">
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo2" class="col-sm-2 col-form-label">School Logo</label>
	      <div class="col-sm-7">
	      	<img src="<?php echo $rowInf["SchoolLogo"] ?>" id="img" height="15%" alt="No Image" class="thumbnail">
	        <input type="file" class="form-control" id="file" placeholder="School Name" name="file" onchange="readURL(this);" />
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo3" class="col-sm-2 col-form-label">Mission</label>
	      <div class="col-sm-7">
	        <textarea class="form-control" id="txtSInfo3" placeholder="Mission" name="txtSmission"><?php echo $rowInf["SchoolMission"] ?></textarea>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo4" class="col-sm-2 col-form-label">Vision</label>
	      <div class="col-sm-7">
	        <textarea class="form-control" id="txtSInfo4" placeholder="Vision" name="txtSvision"><?php echo $rowInf["SchoolVision"] ?></textarea>
	      </div>
	    </div>

	    <div class="form-group row">
	      <label for="txtSInfo4" class="col-sm-2 col-form-label">School Hymn</label>
	      <div class="col-sm-7">
	        <textarea class="form-control" id="txtSInfo4" placeholder="School Hymn" name="txtShymn"><?php echo $rowInf["SchoolHymn"] ?></textarea>
	      </div>
	    </div>

	    <input type="submit" value="Save" class="btn btn-primary col-sm-push-2 col-sm-7">
	</div>
</form>
	


<script type="text/javascript">
$(document).ready(function(e){
	$("#uploadimage").on('submit',(function(e){
		e.preventDefault();
		$.ajax({
			url: "ajax_php_schoolInfo.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				bootstrap_alert.warning(data.substr(data.indexOf(',')+1),data.substr(0,data.indexOf(',')), 4000);
			}	
		})
	}))
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

bootstrap_alert = function () {}
bootstrap_alert.warning = function (message, alert, timeout) {
	var e = $("div#schoolInfo");
    $('<div id="floating_alert" class="alert alert-' + alert + ' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + message + '&nbsp;&nbsp;</div>').appendTo(e);


    setTimeout(function () {
        $(".alert").alert('close');
    }, timeout);

}

</script>