<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  
  <script>
  $( function() {
	  var firstTags = new Array();
	  var lastTags = new Array();
	  var firstLastTags = new Array();
	  <?php 
	  if($result = $db->query("select * from employee_information")){
		while($obj = $result->fetch_object()){
			$last = htmlspecialchars($obj->last_name);			//check for first and last name from DB
			$first = htmlspecialchars($obj->first_name);
			$fixedLast = $last;
			$fixedFirst = $first;
			for($i = 0; $i < strlen($last); $i++){				//check for a substring that's most similar
				if($last[$i] === "'")
					$fixedLast = substr($last, 0, $i) . "\\".  substr($last, $i, strlen($last) - $i);
			}
			for($i = 0; $i < strlen($first); $i++){
				if($first[$i] === "'")
					$fixedFirst = substr($first, 0, $i) . "\\".  substr($first, $i, strlen($first) - $i);
			}		
?>
	lastTags.push('<?php echo $fixedLast;?>');		//push forward the suggestion
	firstTags.push('<?php echo $fixedFirst;?>');
	firstLastTags.push('<?php echo $fixedFirst ." ". $fixedLast;?>');
	<?php 
		}
		$result->close();
	}
	?>
    $( "#first" ).autocomplete({				//autocomplete the suggestion based on their input
      source: firstTags
    });
	$( "#last" ).autocomplete({
      source: lastTags
    });
	$( "#firstLast" ).autocomplete({
      source: firstLastTags
    });
  });
  </script>
