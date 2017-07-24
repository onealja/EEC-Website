<!--header and sidebar for nav and database-->

<?php include("_header.php"); 
	  include("_sidebar_header.php");?>
<!doctype html>

<html>
<head>
	<!--css and javascript info-->
	<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script type="text/javascript" src="../js/script.js"></script>
	<title> Records </title>
</head>

<body>
<?php 	//check if we have user id otherwise redirect to landing
if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])){
$id = $_SESSION["uid"];

}
else{
echo "Please sign in to access this page";
sleep(1);
header("Location: landing.php");
exit();
}
?>
<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">All Tasks</h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>
					  <th>Task Type</th>			<!--display task name and type-->
					  <th>Task Name</th>
					</tr>
				  </thead>
				 <tbody>			<!--query top twenty tasks from task table-->
				  <?php if($result = $db->query("select * from task ORDER BY task_id desc LIMIT 0,20")){
							while($obj = $result->fetch_object()){ 
								$task_type_id = htmlspecialchars($obj->task_type_id);
								$task_name = htmlspecialchars($obj->name);
								$url = "display_task.php?t=" . htmlspecialchars($obj->task_id);
								if($result2 = $db->query("select * from task_type WHERE task_type_id = '$task_type_id'")){
									while($obj2 = $result2->fetch_object()){ 
										$task_type_name = htmlspecialchars($obj2->name);
									}
								}
							?>
				  
					<tr>		<!--display task type and task name-->
					  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_type_name; ?></a></th>
					  <td><a href="<?php echo $url; ?>" style="display : block; color:black"></a><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $task_name; ?></a></td>
					</tr>
				  <?php }} ?>
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
				  <?php 
				  include("_sidebar_footer.php"); 
				  $results->close();?>
</body>	
</html>

