<!DOCTYPE html>
<html>
	<link rel="stylesheet" href="login.css">
<head>
</head>
<body>
<?php
  include("_header.php");
  // Connect to the database
  
  // Define database connection constants
  
  if (isset($_POST['submit'])){
	  $user_name = $_POST['user_name'];
	  $user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
	  $password = $_POST['password'];
	  $password = mysqli_real_escape_string($conn,$_POST['password']);
	}

    if (!empty($user_name)){
      // Make sure someone isn't already registered
      $query = "SELECT * FROM log_in WHERE user_name = '$user_name'";
      $query = $db->prepare($query);
      $data = mysqli_query($db, $query);

      if (mysqli_num_rows($data) == 0) {
        // The user_name is unique, so insert the data into the database
        echo '<p>attempting to insert</p>';
         $query = "INSERT INTO log_in (user_name, password) VALUES ('$user_name', '$password')";
        $var = mysqli_query($db, $query);
		
		if ($var){
			echo '<p>Your new account has been successfully created. You\'re now ready to log in.</p>';
		}
		else{
			echo '<p>Failure</p>';
		}
        mysqli_close($db);
        exit();
		}
      else {
		  echo $user_name;
		  // An account already exists for this user_name, so display an error message
		  echo '<p class="error">An account already exists for this user name. Please use a different one.</p>';
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data.</p>';
    }
  }
?>

