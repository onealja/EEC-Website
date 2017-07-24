<?php
/* Submit a new user to the Users database */

// Connect to the database
include("_header.php");

$id = $_SESSION['uid'];			//given a user id, query for all employee information
if($result = $db->query("select * from employee_information where user_id = '$id'")){
		while($obj = $result->fetch_object()){
			$first = htmlspecialchars($obj->first_name);
			$last = htmlspecialchars($obj->last_name);
			$hours = htmlspecialchars($obj->week_hours);
			$phone = htmlspecialchars($obj->phone_number);
			$email = htmlspecialchars($obj->email);
			$major = htmlspecialchars($obj->major);
			$user_name = htmlspecialchars($obj->user_name);
		}
		$result->close();
}
$old_pass = $_POST[old_password];					//hash the password
$old_pass = mysqli_real_escape_string($old_pass);
$hash_old = base64_encode(hash('sha256', $old_pass));
$clamped_old = substr($old, 0, 40);
if(isset($old_pass) && !empty($old_pass)){				//query for a userid based on username and password
	$sql = "SELECT user_id FROM log_in WHERE user_name = '$user_name' AND password = '$clamped_old'";

	// Query to find user in database
	if ($query = $db->query($sql)) {

		// Fetch row and create into array
		$user_row = $query->fetch_object();

		// Check cid for valid account info
		if (empty($user_row)) {					//check if it's valid
			die ('Invalid Username or Password');
		}
	}else {
		die(' "Error: " . $sql . "<br>" . mysqli_error($db)');
	}
}

// Declare variables
$password = $_POST[password];
$password = mysqli_real_escape_string($old_password);

if(isset($password) && !empty($password)){					//store password and hash it
	$hashed_password = base64_encode(hash('sha256', $password));
	$clamped_pass	= substr($hashed_password, 0, 40);
}

if(isset($_POST[first]) && !empty($_POST[first]))				//store variables of first, last phone etc.
	$first = $_POST[first];
if(isset($_POST[last]) && !empty($_POST[last]))
	$last = $_POST[last];
if(isset($_POST[phone]) && !empty($_POST[phone]))
	$phone = $_POST[phone];
if(isset($_POST[email]) && !empty($_POST[email]))
	$email = $_POST[email];
if(isset($_POST[major]) && !empty($_POST[major]))
	$major = $_POST[major];
if(isset($_POST[hours]) && !empty($_POST[hours]))
	$hours = $_POST[hours];


$email = filter_var($email,FILTER_SANITIZE_EMAIL);				//sanitize email
if (!filter_var($email,FILTER_SANITIZE_EMAIL)==false)
{
	
}
else{		//the email is not valid and redirect to index
	echo("$email is not a valid email address");
	header("Landing: index.php");
}

	$login_table = "UPDATE log_in SET user_name = '$user_name', password = '$clamped_pass' WHERE user_id = '$id'";			//check for log_in based on username and password given an id
$employ_table = "UPDATE employee_information SET user_name = '$user_name', first_name= '$first', last_name = '$last', phone_number= '$phone', 
				email= '$email', major= '$major', week_hours = '$hours' WHERE user_id = '$id'";
// Send query
if (mysqli_query($db, $employ_table)) {
    // Redirect to edit profile page after successful registration
	if(isset($clamped_pass) && !empty($clamped_pass)){
		if(mysqli_query($db, $login_table)){				//check if they are successfully registered
				$_SESSION['success_reg'] = 1;
				header("Location: profile.php");
		}
		else
			die('Failed to query Log_In table');
	}else{
		$_SESSION['success_reg'] = 1;
		header("Location: profile.php");
	}
}else {
    die('"Error: " . $employ_table . "<br>" . mysqli_error($db)');
}

?>
