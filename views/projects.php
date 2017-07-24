<!--have header and sidebar for navigation and database information-->

<?php include("_header.php"); 
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
	<title> Records </title>
</head>

<body>
<?php 			//check for user id
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
              <h3 class="panel-title">All Projects</h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>				<!--display the project name and type in a table-->
					  <th>Project Type</th>
					  <th>Project Name</th>
					</tr>
				  </thead>
				 <tbody>	 	<!--query db for projects and display in decsending order-->
				  <?php if($result = $db->query("select * from project ORDER BY project_id desc LIMIT 0,20")){
							while($obj = $result->fetch_object()){ 
								$project_type_id = htmlspecialchars($obj->project_type_id);
								$project_name = htmlspecialchars($obj->name);
								$url = "display_project.php?p=" . htmlspecialchars($obj->project_id);
								if($result2 = $db->query("select * from project_type WHERE project_type_id = '$project_type_id'")){
									while($obj2 = $result2->fetch_object()){ 
										$project_type_name = htmlspecialchars($obj2->name);
									}
								}
							?>
				  
					<tr>
					  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $project_type_name; ?></a></th>
					  <td><a href="<?php echo $url; ?>" style="display : block; color:black"></a><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $project_name; ?></a></td>
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

