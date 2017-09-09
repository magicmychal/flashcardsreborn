<?php
$cmd = filter_input(INPUT_POST, 'upload');
	
	// variable to check if there were upload problems/errors!
	$uploadOk = 0;
	
	if($cmd){
		
		// storing the path to your image directory
		$target_dir = "files/profile/";
 		$target_file = $target_dir . round(microtime(true)). basename($_FILES['fileToUpload']['name']); //specifies the path of the file to be uploaded (i.e. images/Yoda_walk.gif)
		
		// Check if file is an image
		 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		 if($check !== false) {
		 echo "File is an image type " . $check["mime"] . ". ";
		 $uploadOk = 1;
		 } else {
		 echo "File is not an image. ";
		 $uploadOk = 0;
		 }
		
		// Check if file already exists
		 if (file_exists($target_file)) {
		 echo "The file already exists. ";
		 $uploadOk = 0; 
		 } 
		
		// Check if $uploadOk is set to 0 by an error
		 if ($uploadOk == 0) {
		 echo "Sorry, your file was not uploaded. ";
		 // if everything is ok, try to upload file
		 } else {
		 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		// the query inserting target path into database!
			 
			$stmt = $con->prepare("UPDATE user SET imig_url=? WHERE ID=?");
			$stmt->bind_param("si", $target_file, $_SESSION['userid']);
			$stmt->execute();
			$_SESSION['avatar'] = $target_file;
			// close statement
			$stmt->close();
			header('Location: '.$_SERVER['REQUEST_URI']);
		 echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		 } else {
		 echo "Sorry, there was an error uploading your file.";
		 	}
		 }	
		
	// end if cmd:	
	}
?>