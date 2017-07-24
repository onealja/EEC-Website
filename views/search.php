<?php
	
	//use the key to search through the DB where the first name or last name is similar to the key
    $key=$_GET['key'];
    $array = array();
    $db = new mysqli("oniddb.cws.oregonstate.edu","amidong-db","s7whrue6vvn8lbAP","amidong-db");
    $result=$db->query("select user_id,first_name,last_name from employee_information where first_name LIKE '%{$key}%' or last_name LIKE '%{$key}%'");
    while($row=$result->fetch_object())
    {
      $array[] = $row->user_id;
    }
    echo json_encode($array);
?>

