<?php

require_once ("Database/Connection.php");

$isPost = ($_SERVER ["REQUEST_METHOD"] == "POST");

if ($isPost){
	session_start (); 
	
	extract ($_POST);

	if (isset ($comment_id) && !empty ($comment_id)){
		RemoveCommentLike ($_SESSION["id"], $comment_id);
	}

}

?>