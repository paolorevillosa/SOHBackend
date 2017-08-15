<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <title>Test</title>
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
</head>
<body>
   <form action="" method="post" enctype="multipart/form-data">
       Distrito: <select name="yearLevel" id="yearLevel">
            <option>1</option>
            <option>2</option>
        </select> <br> <br>
       Localidade: <select name="localidade" id="localidade">

        </select> <br> <br>
       <input  type="submit" name="button1" id="button1" value="Guardar">
   </form>
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
</body>
</html>