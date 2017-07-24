<?php include("_header.php"); 
	  include("_sidebar_header.php");
	//header and side bar to include db and navigation
?>		
<!doctype html>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script type="text/javascript" src="../js/script.js"></script>	
	<title> Tasks </title>
</head>

<body>
<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){			//get session id
	if(isset($_GET["t"]) && !empty($_GET["t"])){
		$id = $_GET["t"];
		if(isset($_SESSION["tid"])){
			unset($_SESSION["tid"]);
		}
		$_SESSION["tid"] = $id;
	}
	else
		echo "No task selected from tasks page";
}
else{
echo "Please sign in to access this page";
sleep(1);
header("Location: landing.php");						//redirecting to landing page if there is no session id
exit();
}
if($result = $db->query("select * from task where task_id = '$id'")){				//get all the task related information for a given task id from the task table
		while($obj = $result->fetch_object()){
			$name = htmlspecialchars($obj->name);
			$start_date = htmlspecialchars($obj->start_date);			//* means start date, end date, desc, project_id, id, task type etc.
			$end_date = htmlspecialchars($obj->end_date);
			$desc = htmlspecialchars($obj->desc);
			$project_id = htmlspecialchars($obj->project_id);
			$m_id = htmlspecialchars($obj->m_id);
			$task_type_id = htmlspecialchars($obj->task_type_id);
			if($result2 = $db->query("select * from project where project_id = '$project_id'")){
				while($obj2 = $result2->fetch_object()){
					$project_name = htmlspecialchars($obj2->name);
				}
			}
			if($result3 = $db->query("select * from milestones where m_id = '$m_id'")){
				while($obj3 = $result3->fetch_object()){
					$milestone = htmlspecialchars($obj3->name);
				}
			}
			if($result4 = $db->query("select * from task_type where task_type_id = '$task_type_id'")){
				while($obj4 = $result4->fetch_object()){
					$task_type = htmlspecialchars($obj4->name);
				}
			}
		}
		$result->close();
} ?>
<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
           <!--<A href="edit.html" >Edit Profile</A> -->    

        <A href="edit_task.php" >Edit Task</A>					<!--display the tasks--!>
       <br>
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $name; ?> </h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Start Date:</td>
                        <td><?php echo $start_date;  ?></td>			<!--echo the php variables queried from above-->
                      </tr>  
					  <tr>
                        <td>End Date:</td>
                        <td><?php echo $end_date;  ?></td>
                      </tr> 
					  <tr>
                        <td>Description:</td>
                        <td><?php echo $desc;  ?></td>
                      </tr> 
					  <tr>
                        <td>Project Name:</td>
                        <td><?php echo $project_name;  ?></td>
                      </tr> 
					  <tr>
                        <td>Task Type:</td>
                        <td><?php echo $task_type;  ?></td>
                      </tr> 
					  <tr>
                        <td>Milestone:</td>
                        <td><?php echo $milestone;  ?></td>
                      </tr> 
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
                 <!--<div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                    </div>-->
            
          </div>
        </div>
      </div>
    </div>
	
	<!-- Employee Information Ends Here -->
	
<?php include("_sidebar_footer.php"); ?>
</body>	
</html>
