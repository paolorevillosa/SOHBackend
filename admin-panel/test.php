<?php
  function getTeacher($id){
      $teacherName = '';
      $ids = explode(",", $id);
      for($x=0;$x<sizeof($ids);$x++){
        if($ids[$x] == ""){
          continue;
        }
        include("config.php");
        $sql = "SELECT * from stg_teacher where TeacherKey = " . $ids[$x];
        $result = mysqli_query($conn ,$sql) OR die(mysqli_error($conn));  
        $row = mysqli_fetch_assoc($result);
        if($x>0){
          $teacherName = $teacherName . "<br>" . $row['LastName'];  
        }
        else{
          $teacherName .= $row['LastName'];  
        }
      }
      return $teacherNamew;
    }
    

    function getSubject($sub){
      $subjects = explode(" and ", $sub);
      $subject = $subjects[0];
      if(sizeof($subjects)!=1){
        $subject = $subjects[0] ."<br>" . $subjects[1];
      }
      return $subject;
    }

    echo getSubject("Edukasyong sa Pagpapakatao and Araling Panlipunan");

?>