<!DOCTYPE html>
<?php include("_header.php"); 
include("_sidebar_header.php");
//include header for database and side bar for navigation
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">

    <title>Submit Hours</title>


</head>

<body>
        <!-- Start Page Content -->

<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){			//check if they have session id otherwise redirecto to landing.php
	$id = $_SESSION["uid"];
}
else{
	echo "Please sign in to access this page";
	sleep(1);
	header("Location: landing.php");					//redirecting to landing page
	exit();
}
?>

<div class="container" >
  <div class="row">
	  <div class="col-md-6">
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Input Hours</h3>				<!--from to input number of hours-->
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >
			<!--form for input for number of hours by asking for task id, hours, descirption, submit--!>
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_hours.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="task_id" class="control-label">Task ID</label>
						  <input name="task_id" type="text" class="form-control" placeholder="#########" required>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="hours" class="control-label">Hours</label>
						  <input name="hours" type="text" class="form-control" id="hours" placeholder="#.#" required>
					  </div><br>
					  <div class="form-group col-sm-10">
						  <label for="description" class="control-label">Description</label>
						  <textarea name="description" type="text" class="form-control" rows="3" placeholder="" required>
					  </div><br>
					  <div class="form-group" align= "right">
						  <button type="submit" class="btn btn-primary">Submit</button>			<!--record task id, hours and description -->
					  </div>
			  </form>
		  </div>
		  </div>
		  </div>
	  </div>
</div>	
</div>
</div>
	    <!-- End Page Content -->
</body>
<?php include("_sidebar_footer.php");?>
