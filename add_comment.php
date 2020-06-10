<?php

require_once ("Database/Connection.php");

$isPost = ($_SERVER ["REQUEST_METHOD"] == "POST");

session_start ();

if ($isPost && isset($_SESSION["id"])){

	extract ($_POST);
	
	if (isset ($image_id) && !empty ($comment)){
		AddComment ($_SESSION["id"], $image_id, $comment);
	}

}

?>