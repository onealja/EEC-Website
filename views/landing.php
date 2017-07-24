<!--LANDING PAGE-->

<!DOCTYPE html>
<?php include("_header.php"); 		//header and sidebar incase we need database or sidebar
include("_sidebar_header.php");?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EEC Homepage</title>

</head>

<body>
        <!-- Start Page Content -->
        
	<!--sign in - can only create an account once you have a valid username and password-->
	<!--the background is expressed through a jumbotron-->

                        <h1>Welcome to EEC Homepage</h1>
						<?php 		//check for session id
						if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){echo 
                        '<p>Use the sidebar to navigate</p>' ;
						}else{ echo '		
						<div class="jumbotron" style="background-image: url(factory.jpg); height: 700px; background-size: 100%;">
							<div id="centershit">
							<form data-toggle="validator" role="form" class="navbar-form pull-right" action="submit_login.php" autocomplete="off" method="post">
                      <input class="span2" name="user_name" type="text" value="onealja" required><br>
                      <input class="span2" name="password" type="password" value="onealja" required><br>
                      <button type="submit" class="btn btn-primary">Sign in</button>
                  </form>

					</div>'; } 
	//End page content, include sidebar footer 
						include("_sidebar_footer.php");?>
</body>

</html>
