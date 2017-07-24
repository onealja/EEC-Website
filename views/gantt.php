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
}
else{
echo "Please sign in to access this page";
sleep(1);
header("Location: landing.php");							//redirecting
exit();
}
?>


	<!--these are the options for viewing: day, week month, year--!>

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
	gantt.load('data_no_filter.php');
										//loads data to Gantt from the database

	var dp=new gantt.dataProcessor("data_no_filter.php");  
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
<?php include("_sidebar_footer.php"); ?>
</body>	
</html>