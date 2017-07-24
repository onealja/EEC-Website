<?php
/* Main logout script */
include("_header.php");
// Remove all session variables
session_unset();

// Destroy the session
session_destroy();

if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){
die("failed to remove");}
// Redirect to login page
header("Location: landing.php");

?>
