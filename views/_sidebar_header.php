
<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/simple-sidebar.css" rel="stylesheet">

<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    
                        <?php 
				if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){ 
					echo '<A href="submit_logout.php" >Logout</A>';}
				else{
					echo '<a href="landing.php">Login</a>';}?>

                   
                </li>
				<?php 
				if(isset($_SESSION['uid']) && !empty($_SESSION['uid'])){ 
				echo ' 
                <li>
                    <a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="registration.php">Add New Employee</a>
                </li>
                <li>
                    <a href="gantt.php">Gantt</a>
                </li>
                <li>
                    <a href="records.php">Employee Records</a>
                </li>
				<li>
                    <a href="assignments.php">Assign Hours</a>
                </li>
				<li>
                    <a href="log_hours.php">Log Hours to Task</a>
                </li>
                <li>
                    <a href="create_task.php">Create Task</a>
                </li>
                <li>
                    <a href="create_project.php">Create Project</a>
                </li>
				<li>
                    <a href="projects.php">Projects</a>
                </li>
				<li>
                    <a href="tasks.php">Tasks</a>
                </li>' ;}
				else {
				echo "Please Log in";}?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
<div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">