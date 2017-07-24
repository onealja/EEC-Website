<!--sidebar and header for navigation and database tables-->

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

    <title>Edit Profile</title>


</head>

<body>

        <!-- Start Page Content -->
		<?php 				//check if the session id for the userid is stored
		if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){		
			if(isset($_SESSION['success_reg']) && !empty($_SESSION['success_reg'])){			//check for successful registration
			if($_SESSION['success_reg'] === 1){
				echo '<span style="color:#AFA;text-align:center;">Update Successful</span>';
			}else{
			echo '<span style="color:#E60;text-align:center;">Unsuccessful Update, username already taken.</span>';}
			unset($_SESSION['success_reg']);}
			$id = $_SESSION["uid"];
			if($result = $db->query("select * from employee_information where user_id = '$id'")){			//query employee information table for a specific user id to get first name, last name, phone number email etc.
				while($obj = $result->fetch_object()){
					$first = htmlspecialchars($obj->first_name);
					$last = htmlspecialchars($obj->last_name);
					$user = htmlspecialchars($obj->user_name);
					$phone = htmlspecialchars($obj->phone_number);
					$email = htmlspecialchars($obj->email);
					$major = htmlspecialchars($obj->major);
					$current = htmlspecialchars($obj->current);
					$hire_date = date_create(htmlspecialchars($obj->hire_date));
					$end_date = date_create(htmlspecialchars($obj->end_date));
					$week_hours = htmlspecialchars($obj->week_hours);
					$image_data = $obj->pic;
				}
				$result->close();
			} 
			else
				echo "error";?>
<div class="container" >
  <div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Change Information</h3>
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_edit_profile.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="first" class="control-label">First Name</label>				<!--this is the from to submit the changes to first name, last name, phone number, email, major, weekly hours etc -->
						  <input name="first" type="text" class="form-control" placeholder="<?php echo $first;?>" >
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="last" class="control-label">Last Name</label>
						  <input name="last" type="text" class="form-control" placeholder="<?php echo $last;?>" >
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="phone" class="control-label">Phone Number</label>
						  <input name="phone" type="text" class="form-control" placeholder="<?php echo $phone;?>" >
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="email" class="control-label">Email</label>
						  <input name="email" type="text" class="form-control" placeholder="<?php echo $email;?>" >
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="major" class="control-label">Major</label>
						  <input name="major" type="text" class="form-control" placeholder="<?php echo $major;?>" >
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="hours" class="control-label">Weekly Hours</label>
						  <input name="hours" type="text" class="form-control" placeholder="<?php echo $week_hours;?>" >
					  </div>	  
		  </div>
		  </div>
		  </div>
	  </div>
</div>	
  <div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Change Login</h3>
            </div>		<!--this is the form to change login information which displays the username but requires them to enter the old password before entering the new one-->
			<div class="panel-body">
		  <div class="container-fluid" >
					  <div class="form-group col-sm-6">
						  <label for="user_name" class="control-label">Username</label>
						  <input name="user_name" type="text" class="form-control" value="<?php echo $user;?>" readonly>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="old_password" class="control-label">Old Password</label>
						  <input name="old_password" type="password" data-minlength="5" class="form-control" id="old_password" placeholder="Old Password" >
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="password" class="control-label">New Password</label>
						  <input name="password" type="password" data-minlength="5" class="form-control" id="password" placeholder="New Password" >
						  <span class="help-block">Minimum of 5 characters</span>
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="confirm_password" class="control-label">Confirm New Password</label>
						  <input name="confirm_password" type="password" data-minlength="5" class="form-control" id="confirm_password" placeholder="New Password" >
						  <span class="help-block">Minimum of 5 characters</span>
					  </div><br>
		  </div>
		  </div>
		  </div>
		  <div class="form-group" align= "right">
						  <button type="submit" class="btn btn-primary">Submit</button>
					  </div>
			  </form>
	  </div>
</div>	
</div>
	    <!-- End Page Content -->
		<script>
			//this script double checks that the old passwords match and sets the new password
			var password = document.getElementById("password")
		  , confirm_password = document.getElementById("confirm_password");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
	
	</script>
		<?php }
		else{
			echo "Please sign in to access this page";
			header("Location: landing.php");
			exit();
		}include("_sidebar_footer.php"); ?>
</body>
