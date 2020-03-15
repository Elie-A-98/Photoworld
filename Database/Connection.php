<?php 

require "Upload.php";

$host = "localhost";
$username = "root";
$password = "" ;
$database = "testsite";


$conn = "mysql:host=$host;dbname=$database";
$connected = true ;



function OpenConnection () {
	$GLOBALS["conn"] = mysqli_connect("localhost","root","","testsite");
	if ($GLOBALS["conn"]->connect_error){
		$connected = false ;
		echo "<script type='text/javascript'> alert ('Error connecting to the database, please try again later'); </script>";
	}
}

function CloseConnection () {
	mysqli_close ($GLOBALS["conn"]);
}

function InsertUser ($fname, $lname, $email, $pass, &$new_user_id){
	OpenConnection () ;
	
	$query = "call InsertUser('$fname','$lname','$email','$pass',@id)";
	$InsertResult = mysqli_query ($GLOBALS["conn"], $query);

	$result = mysqli_query($GLOBALS["conn"],"select @id");
	$new_user_id = mysqli_fetch_assoc($result)["@id"];

	CloseConnection () ;

	//Create User directory in Uploads
	CreateUserDir ($new_user_id);

	return $InsertResult;

}

function getCurrentUser ($id) {
	OpenConnection () ;

	$query = "select * from user where id='$id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function getUserLogin ($email, $password){
	OpenConnection ();

	$query = "select * from user where email='$email' and password='$password'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function getUserImages ($user_id){
	OpenConnection () ;

	$query = "select * from image where id_user='$user_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function InsertImage ($user_id, $title, $url, $description, $image_to_upload, $isImageLocal){
	OpenConnection () ;

	$result ;
	if (!$isImageLocal){

		$query = "call InsertImage ($user_id, '$title', '$url', '$description', @id)";
		$result = mysqli_query ($GLOBALS["conn"], $query);

	}else {

		$query = "call InsertImage ($user_id, '$title', 'TO BE ALTERED', '$description', @id)";
		$result = mysqli_query ($GLOBALS["conn"], $query);

		$result = mysqli_query($GLOBALS["conn"],"select @id");
		$image_id = mysqli_fetch_assoc($result)["@id"];	// Get last Image id

		$uploader = new ImageUploader ($user_id);
		$uploader->UploadImage ($image_id, $image_to_upload); // Add image to local Uploads

		$location = $uploader->getImagePath ($image_id, $image_to_upload); // get Local path to store in database
		
		$query = "update image set location='$location' where id='$image_id'";	// Store local path in database
		$result = mysqli_query ($GLOBALS["conn"], $query);
		
	}
	
	CloseConnection ();
	return $result ;
}

function getUserSettings ($user_id){
	OpenConnection ();

	$query = "select * from user_settings where user_id='$user_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function changeImageSectionColor ($id, $color){
	OpenConnection () ;

	$query = "update user_settings set image_section_color='$color' where user_id='$id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

?>