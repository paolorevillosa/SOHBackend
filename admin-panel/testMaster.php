<select name="yearLevel" id="yearLevel" class = "form-control">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
</select>

<lable id="localidade"></lable>
<script type="text/javascript">
       $(document).on('change','#yearLevel',function(){
             var val = $(this).val();
             $.ajax({
                   url: 'test2.php',
                   data: {yearLevel:val},
                   type: 'GET',
                   dataType: 'html',
                   success: function(result){
                        $('#localidade').html();  
                        $('#localidade').html(result); 

                   }
              });
       });
  </script>