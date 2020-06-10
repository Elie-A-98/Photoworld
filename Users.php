<?php

require_once "Database/Connection.php";

session_start () ;

 if (!isset ($_SESSION ["id"])) exit () ;

$users = getUsers () ;

?>

<!DOCTYPE HTML>

<html>

<head>

	<meta name="viewport" content="width=device-width, height=device-height initial-scale=1.0">
	<meta charset="UTF-8">

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="AllStyle.css" rel="stylesheet" type="text/css">

	<style>

		.user-card {
			cursor: pointer;
		}
		.user-card:hover {
			opacity: 0.8;
		}

	</style>

</head>


<body>

	<?php include "Navigation.php"; ?>

	<?php function AddUser ($user_id, $name, $email) { ?>
		<div class="user-card w3-card-4 w3-dark-grey w3-round w3-animate-opacity w3-quarter w3-margin" 
			data-user-id = "<?php echo $user_id; ?>"
			data-user-name = "<?php echo $name; ?>"
			data-user-email = "<?php echo $email; ?>"
			onclick = "UserClicked (this)">

			<h2 class="w3-center w3-padding" style="margin: 0;">
				<?php echo $name; ?>
			</h2>

			<div class="w3-center" style="">
				<img src="avatar.png" style="width: 90%;">
			</div>

			<h4 class="w3-center w3-padding" style="margin: 0;">
				<?php echo $email; ?>
			</h4>
		</div>
	<?php
	}
	?>

	<div class="w3-row-padding">

	<?php

	while ($user = mysqli_fetch_assoc ($users)){
		extract ($user);
		AddUser ($id, $name, $email);	
	}
	?>

	</div>

</body>

<script src = "NavScript.js" type="text/javascript"></script>
<script>

function UserClicked (e) {
	e = e || window.event;

	var user_id = e.getAttribute ("data-user-id");
	var name = e.getAttribute ("data-user-name");
	var email = e.getAttribute ("data-user-email");
	
	window.location.href = "User.php?user_id="+user_id+"&user_name="+name+"&user_email="+email;
}

</script>

</html>