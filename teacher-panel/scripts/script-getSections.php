<?php   

 include "../config.php";

 $id = $_GET['yearLevel'];
 //$id = 1;

 $sql = "SELECT * FROM stud_StudentGroup WHERE YearLevelKey = $id";

 $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $cnt = mysqli_num_rows($result);
 echo '<option value=0></option>';
  while($row = mysqli_fetch_assoc($result)){
    echo '<option value="'.$row["StudentGroupKey"].'">'.$row["StudentGroupName"].'</option>';
  }

?>