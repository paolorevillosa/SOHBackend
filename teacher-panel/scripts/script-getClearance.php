<?php   

 include "../config.php";
 	$sectionKey = $_GET['section'];
 	$yearLevel = $_GET['yearLevel'];
	$sql = "SELECT a.StudentKey,concat(a.LastName,', ',a.FirstName,' ',a.MiddleName) AS Name,a.StudentNo
			,b.Guidance,b.Library
			FROM school_enrollee c 
			LEFT JOIN stud_student a 
			ON c.StudentKey = a.StudentKey 
			LEFT JOIN stud_clearance b 
			ON b.EnrolleeKey = c.EnrolleeKey
			WHERE c.StudentGroupKey = $sectionKey AND c.YearLevelKey = $yearLevel
			ORDER BY c.EnrolleeKey";


	$result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if(mysqli_num_rows($result) > 0){
		echo '<table class="table table-border">
				<thead>
					<tr>
						<th>Student #</th>
						<th>Name</th>
						<th>Library</th>
						<th>Guidance</th>
						<th>Finance</th>
					</tr>
				</thead>
				<tbody>';
		while($row = mysqli_fetch_assoc($result)){
				$key = $row['StudentKey'];
				$getBal = "SELECT A.FinanceKey,
							(A.TuitionFee - (case when (SUM(B.Amount) = NULL) THEN 0 ELSE SUM(B.Amount) END)) as Balance
							FROM school_finance A
							LEFT JOIN school_finance_details B
							ON A.FinanceKey = B.FinanceKey
							LEFT JOIN stud_student C
							ON c.StudentKey = A.StudentKey
							WHERE A.StudentKey = $key";
				$result2 = mysqli_query($conn,$getBal)or die(mysqli_error($conn));
				$initBal = "Not Cleared";
				if(mysqli_num_rows($result2) > 0){
					$row2 = mysqli_fetch_assoc($result2);
					$initBal = $row2['Balance'] > 0 ? "Not Cleared" : "Cleared";
				}
				echo'	<tr>
						<td>' . $row["StudentNo"] . '</td>
						<td>' . $row["Name"] . '</td>
						<td>' . $row["Library"] . '</td>
						<td>' . $row["Guidance"] . '</td>
						<td>' . $initBal . '</td>
					</tr>';
		}
		echo' 	</tbody>
			</table>';
	}
	else{
		echo '<table class="table table-border">
			<th class="text-center">NO RECORD FOUND</th>
			<table>';
	}

?>