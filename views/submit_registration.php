<?php
/* Submit a new user to the Users database */

// Connect to the database
include("_header.php");

// Declare variables
$user_name        = $_POST[user_name];
$password        = $_POST[password];
$first = $_POST[first];
$last = $_POST[last];
$phone = $_POST[phone];
$email = $_POST[email];

$email = filter_var($email,FILTER_SANITIZE_EMAIL);
if (!filter_var($email,FILTER_SANITIZE_EMAIL)==false)
{
	//echo("$email is a valid email address");
}
else{
	echo("$email is not a valid email address");
	header("Landing: index.php");
}

$major = $_POST[major];
$hire = date("Y-m-d", strtotime($_POST[hire]));
$hours = $_POST[hours];
$hashed_password = base64_encode(hash('sha256', $password));

//Check database to see if username is in use already
$username_check = "SELECT * FROM log_in WHERE user_name = '$user_name'";
$query = $db ->query($username_check);
$used_username = $query ->fetch_object();
if(!empty($used_username)){
	$_SESSION['success_reg'] = 2;
	header("Location: registration.php");
	exit();
}

do{
//generate random user id
$user_id = rand(1, 999999999);

//Query database to make sure ID has not been used already
$id_check = "SELECT * FROM log_in WHERE user_id = '$user_id'";
$query = $db ->query($id_check);
//Check to see if object is returned with that user id
$used_id = $query->fetch_object();
//if $user_id is not empty it means someone already has that user id so this should loop over again
}while(!empty($used_id));




$login_table = "INSERT INTO log_in (user_id, user_name, password) VALUES ('$user_id','$user_name', '$hashed_password')";
$employ_table = "INSERT INTO employee_information (user_id, user_name, first_name, last_name, phone_number, email, major, hire_date, week_hours)
				VALUES ('$user_id', '$user_name', '$first', '$last', '$phone', '$email','$major','$hire','$hours')";

// Send query
if (mysqli_query($db, $login_table) && mysqli_query($db, $employ_table)) {
    // Redirect to login page after successful registration
	$_SESSION['success_reg'] = 1;
	header("Location: registration.php");
} 
else {
    echo "Error: " . $employ_table . "<br>" . mysqli_error($db);
}

?>
