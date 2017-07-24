<?php
/* Submit a new user to the Users database */

// Connect to the database
include("_header.php");
// Declare variables
$id = $_SESSION['uid'];
// Image submitted by form. Open it for reading (mode "r")
$fp = fopen($_FILES['image']['tmp_name'], "r");   
// If successful, read from the file pointer using the size of the file (in bytes) as the length.    
if ($fp) {
     $content = fread($fp, $_FILES['image']['size']);
     fclose($fp);
     // Add slashes to the content so that it will escape special characters.    
     $content = addslashes($content);        
     // Insert into the table "table" for column "image" with our binary string of data ("content")  
	 $image_upload = "UPDATE employee_information SET pic = '$content' where user_id = '$id'";
     if (mysqli_query($db, $image_upload)) {
		// Redirect to login page after successful registration
		$_SESSION['success_reg'] = 1;
		header("Location: profile.php");
	} 
	else {
		echo "Error: " . $image_upload . "<br>" . mysqli_error($db);
	}
}




?>






