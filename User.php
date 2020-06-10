<?php

session_start ();

require "Database/Connection.php";

if (!isset ($_GET["user_id"])) exit ();

$user_name = $_GET["user_name"];
$user_email = $_GET["user_email"];
$images = getUserImages ($_GET["user_id"]);

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

		.image{
			cursor:pointer;
		}

	</style>

</head>

<body>

		<?php include_once "Navigation.php"; ?>

		<div class="w3-center" style="margin-bottom:50px;">
            <h1><?php echo $user_name; ?><h1>
			<h3><?php echo "($user_email)"; ?><h3>
        </div>

		<?php include_once "ImagesSection.php"; ?>

</body>

<script src = "NavScript.js" type="text/javascript"></script>
<script src = "PhoneScript.js" type="text/javascript"></script>
<script type="text/javascript" src ="Images.js"> </script>

</html>