<div id="wrapper">
<?php
	include("ui-navigation.php");


?>
<!-- Main Content of the Page :: KPR-->
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Grade Information
                </h1>
            </div>
        </div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>List of Students</h3>
					</div>
					<div class="panel-body">
						<div class="col-lg-10">
							<form method="post">
								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Year Level</label>
									<div class="col-sm-3">
										<select name="yearLevel" id="yearLevel" class = "form-control">
											<option value="0"></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Section</label>
									<div class="col-sm-3">
										<select name="section" id="section" class = "form-control">
											
										</select>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- SchedInfo Information -->
					<div class="panel-body">
						<div id="loading" class="hideDiv"><center><img src="../img/progress.gif"></center></div>
						<div id="tblContent">

						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
	<!-- /.container-fluid -->
</div>
<!-- End Main Content :: KPR -->
</div>

<script type="text/javascript">
       $(document).on('change','#yearLevel',function(){
             var val = $(this).val();
             $.ajax({
                   url: "scripts/script-getSections.php",
                   data: {yearLevel:val},
                   type: 'GET',
                   dataType: 'html',
                   success: function(result){
                        $('#section').html();  
                        $('#section').html(result); 
                   }
              });
       });

       $(document).on('change','#section',function(){
       		var val = $(this).val();
       		var yearLevel = $('#yearLevel').val();
       		$('#tblContent').hide();
       		$('#loading').show();
       		$.ajax({
       			url:"scripts/script-getTableGrade.php",
       			data:{section:val,yearLevel:yearLevel},
       			type:'GET',
       			dataType:'html',
       			success: function(res){
       				window.setTimeout(function(){
                 		$('#tblContent').html();  
	                    $('#tblContent').html(res); 
	                    $('#loading').hide();
	                    $('#tblContent').show();
                  	}, 1000);
       			}
       		})
       });
  </script>