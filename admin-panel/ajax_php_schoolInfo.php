<?php
$okFile = 0;
	
	//this is for uploading image on the server
	if(!empty($_FILES["file"]["type"])){
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["file"]["name"]);

		$file_extension = end($temporary);
		if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
		&& in_array($file_extension, $validextensions)) {
			if ($_FILES["file"]["error"] > 0)
			{
				echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
			}
			else
			{
				if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
				}
				else
				{
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../img/".$_FILES['file']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
					$updateImage = ",SchoolLogo = '" . $targetPath . "';";
					$okFile = 1;
				}
			}
		}
		else
		{
			echo "danger,Invalid file Size or Type";
		}
	}
	else{
		$updateImage="";
		$okFile = 1;
	}


if($okFile==1){
	include("scripts/script-complete.php");
	$txtSName = $_POST['txtSname'];
	$txtSmission = $_POST['txtSmission'];
	$txtSvision = $_POST['txtSvision'];
	$txtShymn = $_POST['txtShymn'];

	$sql = "update information set SchoolName = '$txtSName',SchoolMission = '$txtSmission',SchoolVision='$txtSvision',SchoolHymn = '$txtShymn'" . $updateImage;


	if(execSQLajax($sql)){
		echo "success,Information Updated";
	}
	else{
		echo "danger,There is a internal error<br>Please try again later";
	}


}

?>