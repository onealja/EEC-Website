<!--header and sidebar information so we can access database and navigation bar-->
<!DOCTYPE html>
<?php include("_header.php"); 
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
	<link rel="stylesheet" href="../css/style.css" type="text/css">

    <title>Log Hours</title>
	<!--this is the logging hours page-->

</head>

<body>
        <!-- Start Page Content -->

<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){			//check if the user id is available
	if(isset($_SESSION['success_reg']) && !empty($_SESSION['success_reg'])){		//see if registration was sucessful
			if($_SESSION['success_reg'] === 1){
				echo '<span style="color:#AFA;text-align:left;">Successful Registration</span>';
			}elseif($_SESSION['success_reg'] === 2){
				echo '<div class="alert alert-warning" role="alert"> <strong>Warning!</strong> You have logged more hours than assigned on that last task. Contact a manager.  </div>';
				echo '<span style="color:#AFA;text-align:left;">Successful Registration</span>';
			}else{
			echo '<span style="color:#E60;text-align:center;">Unsuccessful Registration, username already taken.</span>';}
			unset($_SESSION['success_reg']);}
}
else{
	echo "Please sign in to access this page";
	sleep(1);
	header("Location: landing.php");		//if they're not signed in, redirect them to landing page
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
              <h3 class="panel-title">Log Hours to Task</h3>			<!--display the log task hours-->
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_log.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="task_type" class="control-label">Task Name</label><br>
						  
							<?php			//query all the information for a given task
								$result = $db ->query("SELECT * FROM `task`");
								$option1.="<select name='task_name'>";
								while($obj = $result->fetch_object()){
									
								   $option1.="<option value=" . $obj->task_id . ">" . $obj->name . "</option> ";
								}
								$option1.="</select>"; 
								echo $option1;
							?>
						  
					<!--form for submitting log hours-->
					<!--hours such as hours, description, date must all be recorded-->
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="hours" class="control-label">Hours</label>
						  <input name="hours" type="text" class="form-control" id="hours" placeholder="hours" required>
					  </div><br>
					  <div class="form-group col-sm-12">
						  <label for="description" class="control-label">Description</label>
						  <textarea name="description" type="text" class="form-control" rows="3" placeholder="" required></textarea>
					  </div><br>
					  <div class="form-group col-sm-6" align="left">
						  <label for="date" class="control-label">Date Worked</label>
						  <input name="date" type="text" class="form-control" id="date" placeholder="yyyy-mm-dd" required>
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
