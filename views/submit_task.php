<?php
/* Submit a new user to the Users database */

// Connect to the database
include("_header.php");

// Declare variables
$task_type_id		= $_POST[task_type];
$task_type_id 		= mysql_real_escape_string($task_type_id);

$project_id 		= $_POST[project];
$project_id 		= mysql_real_escape_string($project_id);

$start_date 		= date("Y-m-d", strtotime($_POST[start_date]));
$start_date 		= mysql_real_escape_string($start_date);

$end_date 			= date("Y-m-d", strtotime($_POST[end_date]));
$end_date 			= mysql_real_escape_string($end_date);

$desc				= $_POST[description];
$desc				= mysql_real_escape_string($desc);

$name				= $_POST[name];
$name				= mysql_real_escape_string($name);

$m_id				= $_POST[milestone];
$m_id				= mysql_real_escape_string($m_id);

//calculates duration as an integer difference between start and end date (used in gantt_tasks query)
if($duration = $db ->query("SELECT DATEDIFF('$end_date', '$start_date') AS duration")){
	//returns the integer as a column called duration defined in the query above
	$obj1 = $duration->fetch_object();
	$duration = $obj1->duration;
}
else{
	echo "failed to calculate duration";
}


//parent is used to place a task inside the correct project folder
if($parent = $db ->query("SELECT id FROM `gantt_tasks` WHERE project_id='$project_id' AND parent='0'")){
	$obj2 = $parent->fetch_object();
	$parent = $obj2->id;
}
else{
	echo "failed to find parent";
}

//desc is an SQL keyword and must be surrounded by back ticks (also known as a grave accent)
$task_table = "INSERT INTO task ( name, start_date, end_date, `desc`, project_id, m_id, task_type_id ) VALUES ('$name', '$start_date', '$end_date', '$desc', '$project_id', '$m_id', '$task_type_id')";


//Send both querys
if (mysqli_query($db, $task_table)) {
	//get id of last insert
	$task_id = mysqli_insert_id($db);
	//query to insert the task into the gantt_tasks table
	$gantt_tasks = "INSERT INTO gantt_tasks ( text, start_date, duration, parent, project_id, task_id ) VALUES ('$name', '$start_date', '$duration', '$parent', '$project_id', '$task_id')";
	
	if (mysqli_query($db, $gantt_tasks)) {
		// Redirect to tasks page after successful insertion
		header("Location: display_task.php?t=$task_id");
	}
	else {
		echo "Error: " . $gantt_tasks . "<br>" . mysqli_error($db);
	}
} 
else {
    echo "Error: " . $task_table . "<br>" . mysqli_error($db);
}

?>
