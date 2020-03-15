<?php

$uploads_dir = "Uploads/";

if (!file_exists ($uploads_dir)){
	mkdir ($uploads_dir, 0700);
}

// Create a directory inside Upload dir
function CreateDir ($dir){
	if (!file_exists($dir)){
		mkdir ($dir, 0700);
	}
}

function getUserDir ($user_id){
	return $GLOBALS["uploads_dir"]."/User_".$user_id."/";
}

function CreateUserDir ($user_id){
	$dir = getUserDir ($user_id);
	CreateDir ($dir);
}

class ImageUploader {

	private $user_id;
	private $last_uploadd_image = "";

	function  __construct ($user_id){
		$this->user_id = $user_id;

		CreateDir ($this->getImagesDir ());
	}

	function getImagesDir (){
		return getUserDir($this->user_id)."Images/";
	}

	function getImagePath ($image_id, $image_to_upload){
		return $this->getImagesDir().$image_id."_".basename($image_to_upload["name"]);
	}

	function UploadImage ($image_id, $image_to_upload) {

		extract ($_FILES);

		if (isset ($image_to_upload)) {
			$image_path = $this->getImagesDir().$image_id."_".basename($image_to_upload["name"]);
			
			
			if ( !move_uploaded_file ($image_to_upload["tmp_name"], $image_path) ){
				echo "<script> alert ('move_upload error: ".$image_to_upload["error"]."'); </script>";
				return ;
			}
		}

	}

}

?>