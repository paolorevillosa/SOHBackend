<?php
	
	//set_time_limit(0) ;
	//echo TotalSubject();
	echo '<pre>';
	//print_r(subjectShuffle());
	echo '</pre>';
	function subjectShuffle(){
		include('config.php');
		$sqlSub = "select * from stg_subject";
	
		$result = mysqli_query($conn ,$sqlSub)OR die(mysqli_error($conn));
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$arraySub[] = $row['SubjectKey'];
			}
		}

		$groupKeys = getSbjGroup();

		shuffle($arraySub);
		$idYL = 1; //init idYL data
		for($x=0;$x<=24;$x++){ // this is for the number of of subject/sec to be produced by the system 
			shuffle($arraySub);
			//this will reset the array to avoid runtime error
			if($idYL < $groupKeys[$x]){
				$forCheckingArray = array();
			}
			if($x>0 && array_filter($forCheckingArray)){
				while(array_identical($forCheckingArray,$arraySub)){
					shuffle($arraySub);
				}
			}
			$idYL = $groupKeys[$x];
			$forCheckingArray[] = $arraySub;

			//final Array :: dont touch this
			$finalArray[] = $arraySub;
		}
		$result->close();
		return $finalArray;
	}


	
	
	function TotalSubject(){
		include("config.php");
		$sql = "select * from vw_totalsubject";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		$row = mysqli_fetch_assoc($result);
		$result->close();
		return $row['TotalSubject'];
	}
	function timeKeys(){
		include("config.php");
		$sql = "SELECT * from stg_time WHERE Status = 0";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['TimeKey'];
		}
		$result->close();
		return $data;	
	}
	
	//MAIN FUNCTION OF SCHEDULE :: THIS WILL AUTO GENERATE STUDENT SCHEDULES
	$studgrp = 1;
	$sysTimeKey = getTime();
	$adviserKey = getTeacher();
	$idenAdviser = 0;
	foreach(subjectShuffle() as $arr){
		include('config.php');
		
		$timeKey = 0;
		foreach($arr as $sbjCode){
			$sql = "call sp_getTeacherKey($studgrp,$sbjCode)";
			$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
			
			if(mysqli_num_rows($result) > 0 ){
				$teacherKey="";
				while($row = mysqli_fetch_assoc($result)){
					//echo "TEACHER CODE:" . $row['TeacherKey'] . "<BR>";
					$teacherKey = $teacherKey . $row['TeacherKey'] . ",";
				}
			}
			else{
				$teacherKey = 0;
			}
			
			$result->close(); 
			$conn->next_result();  //this is to avoid out of sync error ::: caused by multiple query inside the loop
			
			insert:
			//this serves as inserting Data in School
			echo $sysTimeKey[$timeKey]['Status'];
			if($sysTimeKey[$timeKey]['Status']==0){
				$sqlInsert = "call sp_AddSched(" . $studgrp . ",'" . $teacherKey . "'," . $sysTimeKey[$timeKey]['TimeKey'] . "," . 8 . "," . $adviserKey[$idenAdviser] . ")";
				$resultInsert = mysqli_query($conn,$sqlInsert) or die (mysqli_error($conn));
				$timeKey++;
				goto insert;
			}
			else{
				$sqlInsert = "call sp_AddSched(" . $studgrp . ",'" . $teacherKey . "'," . $sysTimeKey[$timeKey]['TimeKey'] . "," . $sbjCode . "," . $adviserKey[$idenAdviser] . ")";
				$resultInsert = mysqli_query($conn,$sqlInsert) or die (mysqli_error($conn));
				$timeKey++;
			}
			
			$conn->next_result();
			
			
		}
		$studgrp++;
		$idenAdviser++;
		echo "<br><br>";
		// ."<br>";
	}
	//END OF MAIN FUNCTION
?>



<!-- //schedule Utils -->
<?php
	function getSbjGroup(){
		include("config.php");
		$sql = "SELECT * from stud_StudentGroup";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['YearLevelKey'];
		}
		$result->close();
		return ($data);
	}

	//UTILS for adding sched school_adviser
	function getTeacher(){
		include("config.php");
		$limit = utilsForGetTeacher();
		$sql = "CALL sp_AdviserUtils($limit[0],$limit[1],$limit[2],$limit[3])";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['TeacherKey'];
		}
		$result->close();
		return $data;
	}
	echo "<pre>";
	print_r(getTime());

	function utilsForGetTeacher(){
		include("config.php");
		$sql = "SELECT count(*) as data FROM stud_studentGroup
				GROUP BY YearLevelKey";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row['data'];
		}
		$result->close();
		return ($data);
	}

	//UTILS for adding break in schedules
	function getTime(){
		include("config.php");
		$sql = "SELECT * from stg_time";
		$result = mysqli_query($conn ,$sql)OR die(mysqli_error($conn));
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row;
		}
		$result->close();
		return $data;	
	}



	function array_identical($array1,$array2){
		//this is to check if array is identical in terms of
		//size and value according to their order
		//ARRAY1 IS A MULTIDIMENSIONAL ARRAY
		//ARRAY2 IS A SINGLE ARRAY
		//NOTE :: To much data on ARRAY1 can cause runtime error
		
		//Created by: 	paogorithm
		//Date: 		4/24/2017
		foreach($array1 as $arr){
			$x=0;
			foreach($arr as $checkArr){
				if($checkArr == $array2[$x]){
					return true;
					break;
				}
				$x++;
			}
		}
		return false;
	}
?>

<!--
	SELECT YearLevelKey,count(*) as countPerYearLevel
	FROM stud_studentgroup
	GROUP BY YearLevelKey
-->