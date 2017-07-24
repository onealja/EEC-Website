<?php
//DATA

include ('codebase/connector/db_mysqli.php');
include ('../codebase/connector/gantt_connector.php');
include("_header.php"); 


//connect to database - sensitive info
$dbtype = "MySQL";
$res=mysql_connect("oniddb.cws.oregonstate.edu","amidong-db","s7whrue6vvn8lbAP");
mysql_select_db("amidong-db");


//check project id and gannt chart info for project id
$project_id = $_SESSION["pid"];

$gantt = new JSONGanttConnector($res, $dbtype);
$gantt->filter("project_id", $project_id);
$gantt->render_links("gantt_links","id","source,target,type");
$gantt->render_table("gantt_tasks","id","start_date,duration,text,progress,sortorder,parent,project_id");

?>
