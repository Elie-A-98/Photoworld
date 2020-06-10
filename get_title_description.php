<?php

require_once ("Database/Connection.php");

$title ;
$description ;

$isPost = ($_SERVER["REQUEST_METHOD"] == "POST");

if ($isPost){
	
	extract ($_POST);

	$image = getImage ($image_id);

	$row = mysqli_fetch_assoc ($image);	

	$obj = new stdClass () ;

	$obj->title = $row["title"];
	$obj->description = $row["description"];

	$json = json_encode($obj);

	echo $json;

}

?>