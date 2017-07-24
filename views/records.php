<!--header and sidebar for navigation and database information-->

<?php include("_header.php"); 
	  include("_sidebar_header.php");?>
<!doctype html>

<html>
<head>
	<!--for scripts and css-->
	<meta name="viewport" content="width=device-width, initial-scale=1" content="height=device-height, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	
	<title> Records </title>
</head>

<body>
<?php 

//check for session id user id otherwise redirect to landing page
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
              <h3 class="panel-title">Employee Records </h3>
            </div>
            <div class="panel-body">
              <div class="row">     
                <div class=" col-md-9 col-lg-9 "> 
				<!--have a search bar for first and last name that's autocomplete-->
				<div class="ui-widget">
					<div class="col-xs-6">
					<form method = "post" action="display_record.php" >
						<label for="firstLast">Search: </label>
						<input id="firstLast" name= "firstLast" type = "text" class="form-control" placeholder="First Last"><br>
					<button type="submit" class="btn btn-primary">Search</button>
					</form>
					</div>
				</div>
                  <table class="table">
				  <thead class="thead-inverse">
					<tr>
					  <th>First Name</th>
					  <th>Last Name</th>
					</tr>
				  </thead>
				 <tbody>		<!--the table will display the information after querying the table by displaying all employee information-->
				  <?php if($result = $db->query("select * from employee_information ORDER BY last_name asc LIMIT 0,10")){
							while($obj = $result->fetch_object()){ 
								$first = htmlspecialchars($obj->first_name);
								if(strlen($first) > 13){
									$first = substr($first, 0, 13)  . "..." ;
								}
								$last = htmlspecialchars($obj->last_name);
								if(strlen($last) > 13){
									$last = substr($last, 0, 13)  . "..." ;
								}
								$url = "display_record.php?u=" . htmlspecialchars($obj->user_id);
							?>
				  
					<tr>
					  <th scope="row"><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $last; ?></a></th>
					  <td><a href="<?php echo $url; ?>" style="display : block; color:black"></a><a href="<?php echo $url; ?>" style="display : block; color:black" ><?php echo $first; ?></a></td>
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
				  include("_autocomplete_footer.php");
				  $results->close();?>
</body>	
</html>

