<?php
	echo TotalSubject();
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
		shuffle($arraySub);
		
		for($x=0;$x<=3;$x++){ // this is for the number of of subject/sec to be produced by the system --this will be change according to number of studentGroup
			shuffle($arraySub);
			if($x>0){
				while(array_identical($array,$arraySub)){
					shuffle($arraySub);
				}
			}
			$array[] = $arraySub;
		}
		$result->close();
		return $array;
	}


	function array_identical($array1,$array2){
		//this is to check if array is identical in terms of
		//size and value according to their order
		//ARRAY1 IS A MULTIDIMENSIONAL ARRAY
		//ARRAY2 IS A SINGLE ARRAY
		
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
	
	$studgrp = 1;
	foreach(subjectShuffle() as $arr){
		include('config.php');
		
		$timeKey = 1;
		foreach($arr as $sbjCode){
			$sql = "call sp_getTeacherKey($studgrp,$sbjCode)";
			$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
			
			if(mysqli_num_rows($result) > 0 ){
				$teacherKey="";
				while($row = mysqli_fetch_assoc($result)){
					//echo $row['TeacherKey'] . "<BR>";
					$teacherKey = $teacherKey . $row['TeacherKey'] . ",";
				}
			}
			else{
				$teacherKey = 0;
			}
			
			$result->close(); 
			$conn->next_result();  //this is to avoid out of sync error ::: caused by multiple query inside the loop
			
			
			//this serves as inserting Data in School
			$sqlInsert = "call sp_AddSched($studgrp,$teacherKey,$timeKey,$sbjCode)";
			//$resultInsert = mysqli_query($conn,$sqlInsert) or die (mysqli_error($conn));
			
			$conn->next_result();
			
			$timeKey++;
		}
		$studgrp++;
		echo "<br><br><br><br>";
	}
?>