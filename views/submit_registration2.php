<?php
/* Submit a new user to the Users database */

// Connect to database
include("_header.php");

// Declare variables
$user_name        = $_POST[user_name];
$password        = $_POST[password];
$hashed_password = base64_encode(hash('sha256', $password));

// Define query
$sql = "INSERT INTO log_in (user_name, password) VALUES ('$user_name', '$password')";

// Send query
if (mysqli_query($db, $sql)) {
    // Redirect to login page after successful registration
header("homepage.html");

} 
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

?>
