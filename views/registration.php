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

    <title>EEC Registration</title>


</head>

<body>
        <!-- Start Page Content -->
		<?php 
		if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){		
		if(isset($_SESSION['success_reg']) && !empty($_SESSION['success_reg'])){
			if($_SESSION['success_reg'] === 1){
				echo '<span style="color:#AFA;text-align:center;">Successful Registration</span>';
			}else{
			echo '<span style="color:#E60;text-align:center;">Unsuccessful Registration, username already taken.</span>';}
			unset($_SESSION['success_reg']);}?>
<div class="container" >
  <div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Registration</h3>
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >		<!--displaying information for registration such as username, password, first last, phone number etc-->
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_registration.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="user_name" class="control-label">Username</label>
						  <input name="user_name" type="text" class="form-control" placeholder="Username" required>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="password" class="control-label">Password</label>
						  <input name="password" type="password" data-minlength="5" class="form-control" id="password" placeholder="Password" required>
						  <span class="help-block">Minimum of 5 characters</span>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="first" class="control-label">First Name</label>
						  <input name="first" type="text" class="form-control" placeholder="First" required>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="last" class="control-label">Last Name</label>
						  <input name="last" type="text" class="form-control" placeholder="Last" required>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="phone" class="control-label">Phone Number</label>
						  <input name="phone" type="text" class="form-control" placeholder="1234567890" required>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="email" class="control-label">Email</label>
						  <input name="email" type="text" class="form-control" placeholder="Email" required>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="major" class="control-label">Major</label>
						  <input name="major" type="text" class="form-control" placeholder="Major" required>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="hire" class="control-label">Hire Date</label>
						  <input name="hire" type="date" class="form-control" required>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="hours" class="control-label">Weekly Hours</label>
						  <input name="hours" type="text" class="form-control" placeholder="Hours" required>
					  </div>	  
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
	    <!-- End Page Content -->
		
		<?php }
		else{
			echo "Please sign in to access this page";
			header("Location: landing.php");
			exit();
		}include("_sidebar_footer.php"); ?>
</body>
