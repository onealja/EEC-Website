<!--GANNT CHART CODE - AVAILABLE ONLINE AND CONFIGURED TO EEC NEEDS--!>
<!--THIS DISPLAYS ALL THE PROJECTS ON GANNT WHEREAS DISPLAY_PROJECT DISPLAYS A SPECIFIC PROJECT-->


<?php include("_header.php"); 								//header and side bar
	  include("_sidebar_header.php");?>
<!doctype html>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script type="text/javascript" src="../js/script.js"></script>
	<script src="../codebase/dhtmlxgantt.js"></script>   
	<link href="../codebase/dhtmlxgantt.css" rel="stylesheet">
	<title> Display Project</title>
</head>

<body>
<?php 
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){				//checking if the user_id is available, otherwise redirect to landing page
	if(isset($_GET["p"]) && !empty($_GET["p"])){
		$id = $_GET["p"];
		if(isset($_SESSION["pid"])){
			unset($_SESSION["pid"]);
		}
		$_SESSION["pid"] = $id;							//store their id
		
	}
	else
		echo "No user selected from employee records page.";
}
else{
echo "Please sign in to access this page";
sleep(1);
header("Location: landing.php");							//redirecting
exit();
}

if($result = $db->query("select * from project where project_id = '$id'")){				//get all the project related information for a given project id from the project table
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


	<!--these are the options for viewing: day, week month, year-->

    <input type="radio" id="scale1" name="scale" value="1" /><label for="scale1">Day scale</label>
    <input type="radio" id="scale2" name="scale" value="2" checked /><label for="scale2">Week scale</label>
    <input type="radio" id="scale3" name="scale" value="3" /><label for="scale3">Month scale</label>
    <input type="radio" id="scale4" name="scale" value="4" /><label for="scale4">Year scale</label><br>

    <div id="gantt_here" style='width:100%; height:50%;'></div>

    <script type="text/javascript">

	gantt.config.xml_date = "%Y-%m-%d %H:%i";

	gantt.config.columns=[									//configuring the column view as taskname, startdate, end date, duration etc.
    	{name:"text",       label:"Task name",  tree:true, width:'*' },
    	{name:"start_date", label:"Start time", align: "center" },
    	{name:"duration",   label:"Duration",   align: "center" }
    	//{name:"add",        label:"" }
	];

	gantt.init("gantt_here");	
	gantt.load('data.php');									//loads data to Gantt from the database

	var dp=new gantt.dataProcessor("data.php");  
	dp.init(gantt);

	function setScaleConfig(value){
		switch (value) {
			case "1":
				gantt.config.scale_unit = "day";				//for day view set up the configurations		
				gantt.config.step = 1;
				gantt.config.date_scale = "%d";
				gantt.config.subscales = [
					{unit:"day", step:1, date:"%D" }
				];
				gantt.config.scale_height = 50;
				gantt.templates.date_scale = null;
				break;
			case "2":
				var weekScaleTemplate = function(date){			
					var dateToStr = gantt.date.date_to_str("%d");
					var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
					return dateToStr(date) + " - " + dateToStr(endDate);
				};

				gantt.config.scale_unit = "week";				//for week options set up configurations
				gantt.config.step = 1;
				gantt.config.subscales = [
					{unit:"month", step:1, date:"%M" }
				];
				gantt.templates.date_scale = weekScaleTemplate;
				gantt.config.scale_height = 50;
				break;
			case "3":
				gantt.config.scale_unit = "month";				//for month option set up configurations
				//gantt.config.step = 1;
				gantt.config.date_scale = "%M '%y";
				gantt.config.scale_height = 50;
				gantt.config.subscales = [];
				gantt.templates.date_scale = null;
				break;
			case "4":
				gantt.config.scale_unit = "year";				//for year option set configurations
				gantt.config.step = 1;
				gantt.config.date_scale = "%Y";
				gantt.config.min_column_width = 50;
				gantt.config.subscales = [];
				gantt.config.scale_height = 50;
				gantt.templates.date_scale = null;
				break;
		}
	}

	setScaleConfig('2');

	var func = function(e) {
		e = e || window.event;
		var el = e.target || e.srcElement;
		var value = el.value;
		setScaleConfig(value);
		gantt.render();
	};

	var els = document.getElementsByName("scale");
	for (var i = 0; i < els.length; i++) {
		els[i].onclick = func;
	}
    </script>

<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
			  <!--<A href="edit_project.php" >Edit Project</A> -->    
			  <A align="right" href="edit_project.php" >Edit Project</A>					<!--display the project-->
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
                        <td>Project Lead:</td>
                        <td><?php echo $first . " " . $last;  ?></td>
                      </tr> 
					  <tr>
                        <td>Start Date:</td>
                        <td><?php echo $start_date;  ?></td>			<!--echo the php variables queried from above-->
                      </tr>  
					  <tr>
                        <td>End Date:</td>
                        <td><?php echo $end_date;  ?></td>
                      </tr> 
					  <tr>
                        <td>Project Type:</td>
                        <td><?php echo $project_type;  ?></td>
                      </tr> 
					  <tr>
                        <td>Grant:</td>
                        <td><?php echo $grant_name;  ?></td>
                      </tr>
					  <tr>
                        <td>Description:</td>
                        <td><?php echo $desc;  ?></td>
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
	
<div class="container">

      <div class="row">
	<div class="col-md-5  toppad  pull-right col-md-offset-3 ">
		<A align="right" href="add_task.php" >Add Task</A>
	</div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
  
   	
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Tasks</h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>
					  <th>Task Type</th>
					  <th>Task Name</th>
					</tr>
				  </thead>
				 <tbody>
				  <?php if($result = $db->query("select * from task where project_id = '$id'")){			//query the task information to load to gannt chart
							while($obj = $result->fetch_object()){ 
								$task_type_id = htmlspecialchars($obj->task_type_id);
								$task_name = htmlspecialchars($obj->name);
								$url = "display_task.php?t=" . htmlspecialchars($obj->task_id);		//given a task id
								if($result2 = $db->query("select * from task_type WHERE task_type_id = '$task_type_id'")){
									while($obj2 = $result2->fetch_object()){ 			//display all the tasks for a given task type for a given task id
										$task_type_name = htmlspecialchars($obj2->name);
									}
								}
							?>
				  
					<tr>
					  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
					  <td><a href="<?php echo $url; ?>" style="display : block; color:black"></a><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_name; ?></a></td>
					</tr>
				  <?php }} ?>
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
<?php include("_sidebar_footer.php"); ?>
</body>	
</html>
