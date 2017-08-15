<?php   

 include "../config.php";
 include "script-complete.php";
 	$sectionKey = $_GET['section'];
 	$yearLevel = $_GET['yearLevel'];
 	$schoolYear = getSchoolYear();
	$sql = "SELECT a.StudentKey,a.StudentNo,a.LastName,a.FirstName,a.MiddleName,b.Grade
			FROM school_enrollee c
			LEFT JOIN stud_student a
			ON a.StudentKey = c.StudentKey
			LEFT JOIN stud_grade b 
			ON a.StudentKey = b.StudentKey	
			WHERE c.SchoolYear = '$schoolYear'
			AND c.StudentGroupKey = $sectionKey AND c.YearLevelKey = $yearLevel
			";
	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		echo '<table class="table table-border">
				<thead>
					<tr>
						<th>Student Number</th>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Average</th>
					</tr>
				</thead>
				<tbody>';
		while($row = mysqli_fetch_assoc($result)){
				echo'	<tr>
						<td>' . $row["StudentNo"] . '</td>
						<td>' . $row["LastName"] . '</td>
						<td>' . $row["FirstName"] . '</td>
						<td>' . $row["MiddleName"] . '</td>
						<td>' . $row["Grade"] . '</td>
					</tr>';
		}
		echo' 	</tbody>
			</table>';
	}else{
		echo '<table class="table">
		<th class="text-center">No Records Found</th>
		<table>';
	}

?>