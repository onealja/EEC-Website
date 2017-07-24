<!DOCTYPE html>
<?php include("_header.php"); 
include("_sidebar_header.php");?>			<!--have header and side bar-->
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

    <title>Create Project</title>


</head>

<body>
        <!-- Start Page Content -->

<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){				//check for session id
	$id = $_SESSION["uid"];
	$project_id = $_SESSION["pid"];
}
else{
	echo "Please sign in to access this page";
	sleep(1);
	header("Location: landing.php");						//redirect otherwise
	exit();
}
if($result = $db->query("select * from project where project_id = '$project_id'")){				//get all the project related information for a given project id from the project table
		while($obj = $result->fetch_object()){
			$name = htmlspecialchars($obj->name);
			$start_date = htmlspecialchars($obj->start_date);			//* means start date, end date, desc, project_id, id, task type etc.
			$end_date = htmlspecialchars($obj->end_date);
			$desc = htmlspecialchars($obj->desc);
			$project_id = htmlspecialchars($obj->project_id);
			$grant_id = htmlspecialchars($obj->grant_id);
			$project_type_id = htmlspecialchars($obj->project_type_id);
			$lead_id = htmlspecialchars($obj->lead_id);
		}
		if($result2 = $db->query("select * from `grant` where grant_id = '$grant_id'")){
			while($obj2 = $result2->fetch_object()){
				$grant_name = htmlspecialchars($obj2->name);
			}
		}
		if($result3 = $db->query("select * from project_type where project_type_id = '$project_type_id'")){
			while($obj3 = $result3->fetch_object()){
				$project_type = htmlspecialchars($obj3->name);
			}
		}
		if($result4 = $db->query("select * from employee_information where user_id = '$lead_id'")){
			while($obj4 = $result4->fetch_object()){
				$first = htmlspecialchars($obj4->first_name);
				$last = htmlspecialchars($obj4->last_name);
			}
		}
		$result->close();
		$result2->close();
		$result3->close();
		$result4->close();
}
?>

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
<div class="container" >
  <div class="row">
	  <div class="col-md-6">
		  <br>
		  <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title">Edit Project</h3>				<!--create a project by selecting name, and grant type -->
            </div>
			<div class="panel-body">
		  <div class="container-fluid" >
				  <form data-toggle="validator" role="form" autocomplete="off" action="submit_edit_project.php" method="post">
					  <div class="form-group col-sm-6">
						  <label for="name" class="control-label">Project Name</label>
						  <?php echo "<input name='name' type='text' class='form-control' id='name' value='" . $name .  "'>";?>
						  
					  </div>
					  <div class="form-group col-sm-6">															<!--auto fill for project lead-->
						  <label for="firstLast" class="control-label">Project Lead</label>
						  <?php echo "<input id='firstLast' name= 'firstLast' type = 'text' class='form-control' value='" . $first . " " . $last . "'>";?>
					  </div><br><br><br><br>
					  <div class="form-group col-sm-6">
						  <label for="project_type" class="control-label">Project Type</label><br>
						  
							<?php	//checking against project type
								$result = $db ->query("SELECT * FROM `project_type`");
								$option1.="<select name='project_type'>";
								while($obj = $result->fetch_object()){
									if($obj->project_type_id == $project_type_id){
										$option1.="<option value=" . $obj->project_type_id . " selected>" . $obj->name . "</option> ";
									}
									else{
										$option1.="<option value=" . $obj->project_type_id . ">" . $obj->name . "</option> ";
									}
								}
								$option1.="</select>"; 
								echo $option1;
							?>
						  
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="grant_type" class="control-label">Grant Type</label><br>
						  
							<?php		//choose grant by searching DB
								if($result2 = $db ->query("SELECT * FROM `grant`")){
								
									$option2.="<select name='grant_type'>";
									while($obj2 = $result2->fetch_object()){
										if($obj2->grant_id == $grant_id){
											$option2.="<option value=" . $obj2->grant_id. " selected>" . $obj2->nick . "</option> ";
										}
										else{
											$option2.="<option value=" . $obj2->grant_id. ">" . $obj2->nick . "</option> ";
										}										
									   $option2.="<option value=" . $obj2->grant_id. ">" . $obj2->nick . "</option> ";
									}
									$option2.="</select>"; 
									echo $option2;
								}
								else
									echo "error";
							?>
						  
					  </div><br>
					  <div class="form-group col-sm-6">
						  <label for="start_date" class="control-label">Start Date</label>
						  <?php echo "<input name='start_date' type='date' class='form-control' id='start_date' value=" . $start_date . ">"; ?>
					  </div>
					  <div class="form-group col-sm-6">
						  <label for="end_date" class="control-label">End Date</label>
						  <?php echo "<input name='end_date' type='date' class='form-control' id='end_date' value=" . $end_date . ">"; ?>
					  </div><br>
					  <div class="form-group col-sm-12">
						  <label for="description" class="control-label">Description</label>
						  <?php echo "<textarea name='description' type='text' class='form-control' rows='10'>" . $desc . "</textarea>"; ?>
					  </div><br>
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
<?php include("_autocomplete_footer.php");?>
