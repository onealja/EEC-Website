<!--
ASSIGNMENTS.PHP
--!>


<!DOCTYPE html>
<?php include("_header.php"); 				//imports header and side bar
include("_sidebar_header.php");?>
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
	<link rel="stylesheet" href="../css/style.css" type="text/css">					<!--css--!>

    <title>Create Task</title>
</head>




<body>
        <!-- Start Page Content -->

<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){						//check the sesion id for the username
	if(isset($_SESSION['success_reg']) && !empty($_SESSION['success_reg'])){			//they're already signed in
			if($_SESSION['success_reg'] === 1){
				echo '<span style="color:#AFA;text-align:left;">Successful Registration</span>';
			}else{
			echo '<span style="color:#E60;text-align:center;">Unsuccessful Registration, username already taken.</span>';}
			unset($_SESSION['success_reg']);}
}
else{
	echo "Please sign in to access this page";							//they're not signed in
	sleep(1);
	header("Location: landing.php");
	exit();
}
?>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
<div class="container" >
  <div class="row">
	  <div class="col-md-6">
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Assign Employees</h3>					<!-- assign employee hours !-->
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_assignments.php" method="post">		
					  <div class="form-group col-sm-6">
						  <label for="task_type" class="control-label">Task Name</label><br>
						  
							<?php
								$result = $db ->query("SELECT * FROM `task`");			//select the task
								$option1.="<select name='task_name'>";
								while($obj = $result->fetch_object()){
									
								   $option1.="<option value=" . $obj->task_id . ">" . $obj->name . "</option> ";
								}
								$option1.="</select>"; 
								echo $option1;
							?>
						  
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="hours" class="control-label">Hours</label>				<!--choose hours, first name and last name of employee --!>
						  <input name="hours" type="text" class="form-control" id="hours" placeholder="hours" required>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="first" class="control-label">First Name</label>
						  <input name="first" type="text" class="form-control" id="first" placeholder="First" required>
					  </div>
						  <div class="form-group col-sm-6" >
							  <label for="last" class="control-label" >Last Name</label>
							  <input name="last" type="text" class="form-control" id="last" placeholder="Lirst" required><br>
						  </div>
					  
					  <div class="form-group" align= "right">
						  <button type="submit" class="btn btn-primary">Submit</button>
					  </div>
			  </form>
		  </div>
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
