<!--PROFILE.PHP-->
<!--have header and sidebar if you need database and navigation-->

<?php 
          include("_header.php"); 
	  include("_sidebar_header.php");

?>
<!doctype html>

<html>
<head>
	<!--script and css information-->
	<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<title> Profile </title>
</head>

<body>
<?php
if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){			//check for user id and successful registration
	if(isset($_SESSION['success_reg']) && !empty($_SESSION['success_reg'])){
			if($_SESSION['success_reg'] === 1){
				echo '<span style="color:#AFA;text-align:center;">Update Successful</span>';
			}
			unset($_SESSION['success_reg']);}
	$id = $_SESSION['uid'];
}
else{
echo "Please sign in to access this page";
sleep(1);
header("Location: landing.php");		//redirect if we don't have session id for user id
exit();
}
if($result = $db->query("select * from employee_information where user_id = '$id'")){		//query for a specific user id from employee information table - get back first name, last name, phone number etc.
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
} ?>
<!-- First container with employee information -->
<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">  

        <A href="edit_profile.php" >Edit Profile</A>
       <br>
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $first; ?> <?php echo $last;?> </h3>
            </div>
            <div class="panel-body">
              <div class="row"> 
			  
			  
			  
				<!-- Profile Picture -->
				<div class="col-md-4 col-lg-4 " align="center"> 
				<!-- check to see if user has uploaded an image -->
					<?php if(isset($image_data) && !empty($image_data)){?>
					<!--
					<img alt="User Pic" src="data:image/jpeg;base64,<?php //echo base64_encode( $image_data ); ?>" class="img-circle img-responsive" />
					-->
					<img alt="User Pic" src="../../images/graduate.jpg" class="img-circle img-responsive" />
			  <?php }?>
					<form action="upload_photo.php" method="post" enctype="multipart/form-data" >
					  <div class="form-group" align= "center">
					  <h4> Upload new photo </h4>
					  <input type="file" name="image" required/><br>
						  <button type="submit" class="btn btn-primary">Upload Photo</button>
					  </div>
					</form>
				</div>
				<!-- End Profile Picture -->
				
				
				
			  <!-- Start Table of employee information -->	
			  <div class=" col-md-8 col-lg-8 " align="right"> 
                  <table class="table table-user-information" >
                    <tbody>
                      <tr>
                        <td>Email:</td>
                        <td><a href="mailto:<?php echo $email; ?> "><?php echo $email;  ?></a> </td>
                      </tr>
                      <tr>
                        <td>Phone:</td>
                        <td><?php echo $phone;  ?></td>
                      </tr>  
					  <tr>
                        <td>Major:</td>							<!--table which displays the current information regarding their employee information-->
                        <td><?php echo $major;  ?></td>
                      </tr> 
					  <tr>
                        <td>Hire Date:</td>
                        <td><?php echo date_format($hire_date, "m/d/Y");  ?></td>
                      </tr> 
					  <tr>
                        <td>Expected End Date:</td>
                        <td><?php echo date_format($end_date, "m/d/Y");  ?></td>
                      </tr> 
					  <tr>
                        <td>Weekly Hours:</td>
                        <td><?php echo $week_hours;  ?></td>
                      </tr> 
                    </tbody>
                  </table>
                  
                </div>
				<!-- End Table of employee information -->
				
				
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- End Profile Information -->

<!-- Show Tasks Starts Here -->	
	<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Assigned Tasks </h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>
					  <th>Task Type</th>
					  <th>Task Name</th>
					  <th>Logged Hours</th>
					  <th>Assigned Hours</th>			<!--this shows the specific hours for a given task from a specific employee-->
					</tr>
				  </thead>
				 <tbody>
				  <?php $previous_id = -1;		//query the database about assignment hours
						if($result = $db->query("select * from assignments WHERE user_id = '$id' ORDER BY task_id desc ")){
							while($obj = $result->fetch_object()){ 
								$task_id = htmlspecialchars($obj->task_id);
								if($previous_id === $task_id){
									$assigned_hours = $assigned_hours + htmlspecialchars($obj->hours);
									$previous_id = $task_id;							//check what kind of task id it is if it's the same as the previous task id
									continue;
								}elseif($previous_id === -1){				//or if the id is now -1
									$logged_hours = 0;
									$previous_id = $task_id;
									$assigned_hours = htmlspecialchars($obj->hours);
								}else{?>
									<tr>
									  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:black"><?php echo $task_name; ?></a></td>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $logged_hours; ?></a></td>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $assigned_hours; ?></a></td>
									</tr> <?php
									$logged_hours = 0;
									$previous_id = $task_id;
									$assigned_hours = htmlspecialchars($obj->hours);
								}
								if($result2 = $db->query("select * from task where task_id = '$task_id'")){
									while($obj2 = $result2->fetch_object()){ 			//check for a given task id and get back the name, task type 
										$task_name = $obj2->name;
										$task_type_id = $obj2->task_type_id;
										if($result3 = $db->query("select * from task_type where task_type_id = '$task_type_id'")){
											while($obj3 = $result3->fetch_object()){
												$task_type_name = $obj3->name;
											}
										}
										else
											echo "Error Getting Task Type Information";
									}
								}
								else
									echo "Error Getting Task Information";
								if($result4 = $db->query("select * from log_task where user_id = '$id' and task_id = '$task_id'")){
									while($obj4 = $result4->fetch_object()){
											$logged_hours = $logged_hours + $obj4->hours;
									}						
								}
								$url = "display_task.php?t=" . htmlspecialchars($obj->task_id);
								if(!isset($logged_hours) || empty($logged_hours)){		
									$logged_hours = 0;
								}
								if($assigned_hours < $logged_hours)				//check if they went over the numebr of hours 
											$color = "red";				//red if they did
										else
											$color = "black";			//black if they're still under
							}?>
							<tr>
									  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:black"><?php echo $task_name; ?></a></td>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $logged_hours; ?></a></td>
									  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $assigned_hours; ?></a></td>
									</tr><?php
						} ?>
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
<!-- Show Assigned Tasks Ends Here -->	

<!-- Show Hours Starts Here -->	
	<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Logged Hours </h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>
					  <th>Task Type</th>						<!--displaying a specific task information-->
					  <th>Task Name</th>
					  <th>Logged Hours</th>
					  <th>Assigned Hours</th>
					</tr>
				  </thead>
				 <tbody>
				<?php $previous_id = -1; 
					if($result = $db->query("select * from log_task WHERE user_id = '$id' ORDER BY task_id desc ")){	//check for a specific user id and task desription from log tasks
						while($obj = $result->fetch_object()){ 
							$task_id = htmlspecialchars($obj->task_id);
							if($task_id === $previous_id){
								$logged_hours = $logged_hours + htmlspecialchars($obj->hours);		//display number of log hours
								continue; 
							}
							elseif($previous_id === -1){
								$logged_hours = htmlspecialchars($obj->hours);
							}else{
								if($assigned_hours < $logged_hours)
											$color = "red";					//if the number of logged overs is over the limit
										else
											$color = "black";				//if they're sitll under
								?>
								<tr>
								  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:black"><?php echo $task_name; ?></a></td>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $logged_hours; ?></a></td>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $assigned_hours; ?></a></td>
								</tr> <?php 
								$logged_hours = htmlspecialchars($obj->hours);
							}

							$previous_id = $task_id; 
							$assigned_hours = 0;
							if($result2 = $db->query("select * from assignments where task_id = '$task_id'")){			//check if the task id from assignments 
								while($obj2 = $result2->fetch_object()){ 
									$assigned_hours = $assigned_hours + $obj2->hours;
								}
								if($result3 = $db->query("select * from task where task_id = '$task_id'")){			//query for a given task id
									while($obj3 = $result3->fetch_object()){ 
										$task_name = $obj3->name;
										$task_type_id = $obj3->task_type_id;			//get the task_id_type and name and query again from the task_type
										if($result4 = $db->query("select * from task_type where task_type_id = '$task_type_id'")){
											while($obj4 = $result4->fetch_object()){
												$task_type_name = $obj4->name;
											}
										}
										else
											echo "Error Getting Task Type Information";
									}
								}else
									echo "Error Getting Task Information";
							}
							else
								echo "Error Getting Log Information";
							$url = "display_task.php?t=" . $task_id;
						}
						if($assigned_hours < $logged_hours)
							$color = "red";
						else
							$color = "black";?> 
								<tr>		<!--display all this information-->
								  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:black"><?php echo $task_name; ?></a></td>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $logged_hours; ?></a></td>
								  <td><a href="<?php echo $url; ?>" style="display : block; color:<?php echo $color;?>"><?php echo $assigned_hours; ?></a></td>
								</tr>
								<?php } ?>
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
	
	
	
	
<?php include("_sidebar_footer.php"); ?>
</body>	
</html>
