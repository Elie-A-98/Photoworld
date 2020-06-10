<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="AllStyle.css" rel="stylesheet" type="text/css">
</head>

<?php

require_once "Database/Connection.php";



$isPost = ($_SERVER["REQUEST_METHOD"] == "POST");

$comments;


if ($isPost){

	session_start ();
	$user_id = $_SESSION["id"];

	extract ($_POST);

	$comments = getComments ($image_id, $count);
	$animation = "" ;
	if (isset ($animate) && $animate == "true"){
		$animation = "w3-animate-zoom";
	}

	while ($row = mysqli_fetch_assoc ($comments)){
		$user = getCurrentUser ($row["user_id"]);

		$comment_username = mysqli_fetch_assoc ($user)["name"];
		$comment_content = $row["content"];
		$comment_id = $row["id"];

		$nb_likes = getNbCommentLikes ($comment_id);

?>

	<div class="comment w3-round-xlarge w3-hover-border-cyan w3-card-4 w3-padding <?php echo $animation; ?>">
		<div class = "comment_header w3-border-gray" style="padding: 10px 0;">
			<img src="avatar.png" class="w3-round-large" style="width:30px;">
			<?php echo $comment_username; ?>
		</div>

		<div style="margin-bottom:12px;">
			<?php echo $comment_content; ?>
		</div>

		<?php

			$color = "black";
			$action = "LikeClicked ($comment_id)";

			$is_liked_by_user = IsLikedByUser ($user_id, $comment_id);
			
			if ($is_liked_by_user){
				$color ="blue";
				$action ="RemoveLikeClicked ($comment_id)";
			}

		?>

		<div class="w3-display-container w3-padding">
			<div class ="like_button w3-display-left" style="color:<?php echo $color; ?>;" onclick ="<?php echo $action; ?>;">
				<i class ="fa fa-thumbs-up"></i>
			</div>

			<div class="w3-display-right" style="font-size: 0.8em; font-weight: bold; color:blue;">
				<?php
					$text = " likes";
					if ($nb_likes == 1){
						$text = " like";
					}
					echo $nb_likes.$text;
				?>
			</div>
		</div>
										
	</div>

<?php 
	} 

}

?>