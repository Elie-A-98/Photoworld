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

function IsLikedByUser ($user_id, $comment_id){
	
	$liked = false ;

	OpenConnection () ;

	$query = "select * from comment_like where comment_id='$comment_id' and user_id='$user_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);
	
	if (mysqli_num_rows ( $result) > 0) $liked = true ;

	CloseConnection ();

	return $liked ;
}

function AddComment ($user_id, $image_id, $comment) {
	OpenConnection () ;

	$query = "call AddComment ('$user_id', '$image_id', '$comment')";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function AddCommentLike ($user_id, $comment_id){
	OpenConnection () ;

	$query = "call AddCommentLike ('$user_id', '$comment_id')";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function RemoveCommentLike ($user_id, $comment_id){
	OpenConnection () ;

	$query = "call RemoveCommentLike ('$user_id', '$comment_id')";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function getNbCommentLikes ($comment_id) {
	OpenConnection () ;

	$query = "select count(*) as nb_likes from comment_like where comment_id='$comment_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	$nb_likes = -1 ;
	if ($result){
		$nb_likes = mysqli_fetch_assoc ($result) ["nb_likes"];
	}

	CloseConnection () ;

	return $nb_likes ;
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

function getImage ($image_id){
	OpenConnection () ;

	$query = "select * from image where id='$image_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
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

	$query = "select * from image where user_id='$user_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

function getComments ($image_id, $count){
	OpenConnection () ;

	// $query = "select * from comment_image where image_id='$image_id' LIMIT $count";
	$query = "select * from comment_image where image_id='$image_id'";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	if (!$result){
		throw new Exception (mysqli_error ($GLOBALS["conn"]));
	}

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

function getUsers (){
	OpenConnection () ;

	$query = "select id, name, lastname, email from user";
	$result = mysqli_query ($GLOBALS["conn"], $query);

	CloseConnection ();
	return $result ;
}

?>