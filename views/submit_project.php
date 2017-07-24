<?php
/* Submit a new project to the project table */

// Connect to the database
include("_header.php");

// Declare variables
$project_type_id	= $_POST[project_type];
$project_type_id 	= mysql_real_escape_string($project_type_id);

$grant_id 			= $_POST[grant_type];
$grant_id 			= mysql_real_escape_string($grant_id);

$start_date 		= date("Y-m-d", strtotime($_POST[start_date]));
$start_date 		= mysql_real_escape_string($start_date);

$end_date 			= date("Y-m-d", strtotime($_POST[end_date]));
$end_date 			= mysql_real_escape_string($end_date);

$desc 				= $_POST[description];
$desc 	 			= mysql_real_escape_string($desc);

$name				= $_POST[name];
$name				= mysql_real_escape_string($name);


if($duration = $db ->query("SELECT DATEDIFF('$end_date', '$start_date') AS duration")){
	//returns the integer as a column called duration defined in the query above
	$obj1 = $duration->fetch_object();
	$duration = $obj1->duration;
}
else{
	echo "failed to calculate duration";
}
if(isset($_POST['firstLast']) && !empty($_POST['firstLast'])){
	$combined_name = $_POST['firstLast'];
	for($i = 0; $i < strlen($combined_name); $i++){				//Split the combined first and last into 2 variables
		if($combined_name[$i] === " "){
			$first = substr($combined_name, 0, $i);
			$last = substr($combined_name, $i+1, strlen($combined_name) - $i);
			break;
		}
	}
	//Check first and last name for apostrophes
	for($i = 0; $i < strlen($last); $i++){				
		if($last[$i] === "'"){
			$last = substr($last, 0, $i) . "\\".  substr($last, $i, strlen($last) - $i);
			break;
		}
	}
	for($i = 0; $i < strlen($first); $i++){
		if($first[$i] === "'"){
			$first = substr($first, 0, $i) . "\\".  substr($first, $i, strlen($first) - $i);
			break;
		}
	}
	if($result4 = $db->query("select * from employee_information where first_name = '$first' and last_name = '$last'")){
		while($obj4 = $result4->fetch_object()){
			$project_lead = htmlspecialchars($obj4->user_id);
		}
	}
	//desc is an SQL keyword and must be surrounded by back ticks (also known as a grave accent)
	$project_table = "INSERT INTO project (project_type_id, grant_id, start_date, end_date, `desc`, name, lead_id) VALUES ('$project_type_id','$grant_id', '$start_date', '$end_date', '$desc', '$name', '$project_lead')";
	
}
else{
	//desc is an SQL keyword and must be surrounded by back ticks (also known as a grave accent)
	$project_table = "INSERT INTO project (project_type_id, grant_id, start_date, end_date, `desc`, name, lead_id) VALUES ('$project_type_id','$grant_id', '$start_date', '$end_date', '$desc', '$name')";
}

//query to insert the task into the gantt_tasks table


// Send project query
if (mysqli_query($db, $project_table)) {
	//project_id must be grabbed after project has been inserted into the table
	$project_id = mysqli_insert_id($db);
	//query to insert the task into the gantt_tasks table
	$gantt_tasks = "INSERT INTO gantt_tasks ( text, start_date, duration, parent, project_id ) VALUES ('$name', '$start_date', '$duration', '0', '$project_id')";
} 
else {
    echo "Error: " . $project_table . "<br>" . mysqli_error($db);
}


//Send gant_tasks query
if (mysqli_query($db, $gantt_tasks)) {
	// Redirect to tasks page after successful insertion
	header("Location: display_project.php?p=$project_id");
}
else {
	echo "Error: " . $gantt_tasks . "<br>" . mysqli_error($db);
}

?>
