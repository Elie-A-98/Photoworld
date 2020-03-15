<?php
	session_start ();
?>

<!DOCTYPE HTML>

<html>

<?php

require "Database/Connection.php";

// Fix password pattern (validation)

$fname=$lname=$email=$pass=$gender="";
$fnameErr=$lnameErr=$emailErr=$passErr ="";

if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
	
	
	$fname = $_POST["fname"] ;
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$gender = $_POST ["gender"];
	
	if (!isValid()) {goto render;}
	
	$new_user_id ;
	if (InsertUser ($fname, $lname, $email, $pass, $new_user_id)){
		$_SESSION["id"] = $new_user_id;
		header ("Location:Home.php");
	}
	
}

function isValid () {
	$valid = true ;
	
	if (!empty($GLOBALS["fname"])){
	if ( !preg_match("/^([a-zA-Z]+-?)+$/",$GLOBALS["fname"] ) ) {$GLOBALS["fnameErr"] = "*CAN ONLY CONTAIN LETTERS AND -"; $valid=false ;}
	}else {
		$GLOBALS["fnameErr"] = "*First Name is required"; $valid=false ;
	}
	
	if (!empty($GLOBALS["lname"])){
	if ( !preg_match("/^([a-zA-Z]+-?)+$/",$GLOBALS["lname"] ) ) {$GLOBALS["lnameErr"] = "*CAN ONLY CONTAIN LETTERS AND -"; $valid=false ;}
	}else {
		$GLOBALS["lnameErr"] = "*Last Name is required"; $valid=false ;
	}
	
	if (!empty($GLOBALS["email"]) ){
	if ( !preg_match("/[a-z]+\d*@[a-z]+[.]com/",$GLOBALS["email"]) ) {$GLOBALS["emailErr"] = "*MUST BE OF FORM: username@domain.com"; $valid=false ;}
	}else {
		$GLOBALS["emailErr"] = "*EMAIL IS REQUIRED"; $valid=false ;
	}
	
	if (!empty($GLOBALS["pass"])){
	if ( !preg_match("/(\d[a-z])|([a-z]\d)/", $GLOBALS["pass"]) || strlen($GLOBALS["pass"]) < 6 ) {$GLOBALS["passErr"] = "*MUST BE 6 LETTERS MINIMUM <br> MUST CONTAIN AT LEAST ONE NORMAL LETTER, ONE CAPITAL LETTER AND ONE DIGIT"; $valid=false ;}
	}else {
		$GLOBALS["passErr"] = "*PASSWORD IS REQUIRED"; $valid=false;
	}
	
	return $valid ;
}

render:

?>

<title>Sign Up</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body class="w3-row" style="background:gray;">

<div class="w3-col l3 m8 s10 w3-container w3-card-4 w3-light-grey w3-round w3-display-middle">

<div class="w3-center w3-border-bottom"> <h2>Sign Up</h2></div>

<form class="w3-panel" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" >

<p>
<label>First Name</label>
<input class="w3-input w3-hover-gray w3-round-large" type="text" name="fname" value="<?php echo $fname ?>" > <span style="color:red;"><?php echo $fnameErr ?> </span>
</p>

<p>
<label>Last Name</label>
<input class="w3-input w3-hover-gray w3-round-large" type="text" name="lname" value="<?php echo $lname ?>"> <span style="color:red;"><?php echo $lnameErr ?> </span>
</p>

<p>
<label>Email</label>
<input class="w3-input w3-hover-gray w3-round-large" type="text" name="email" value="<?php echo $email ?>"> <span style="color:red;"><?php echo $emailErr ?> </span>
</p>

<p>
<label>Password</label>
<input class="w3-input w3-hover-gray w3-round-large" type="password" name="password"> <span style="color:red;"><?php echo $passErr ?> </span>
<p>

<p>
<label>
<input class="w3-radio" name="gender" value="male" type="radio" checked="true"> Male
</label> </p>
<p>
<label>
<input class="w3-radio" name="gender" value="female" type="radio"> Female
</label> </p>
<br>

<div>
<input type="submit" class="w3-button w3-round-large w3-dark-gray w3-hover-ligh-black" value="Sign Up" style="float:left;"/>
<input type="reset" class="w3-button w3-round-large w3-dark-gray w3-hover-light-black" value="Reset" style="float:right;"/>
</div>

</form>

</div>

</body>

</html>