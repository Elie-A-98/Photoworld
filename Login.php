<?php
session_start();

require "Database/Connection.php";

$isPost = ($_SERVER["REQUEST_METHOD"]=="POST");
$isSubmit = isset ($_POST["submit"]);
$isSignOut = isset ($_POST["signout"]);

$err = "";

if ($isPost && $isSubmit){
    
    extract ($_POST);
    if (isset ($email) && isset ($email) && !empty ($email) && !empty ($password)){
        $user = getUserLogin ($email,$password);
        if ($user->num_rows > 0){
            $_SESSION["id"] = mysqli_fetch_assoc ($user)["id"];
            header ("Location:Home.php");
        }else {
            $err = "Wrong email or password";
        }
    }else {
        $err ="Inavlid input";
    }
    
}else if ($isPost && $isSignOut){
    session_destroy ();
}

?>

<!DOCTYPE HTML>

<html>

	<title>Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	

	<body class="w3-row" style = "background-color:gray;">

		<div class = "w3-col l3 m8 s10 w3-card-4 w3-light-gray w3-round w3-display-middle">
			
			<h2 class="w3-center w3-border-bottom">Login</h2>
			
			<h4 class="w3-center w3-text-red"> <?php echo $err;?> </h4>

			<form class="w3-panel" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
				
				<p style="margin-bottom: 30px;">
					<label>Email:</label>
					<input class="w3-input w3-hover-gray w3-round-large" type="text" name="email">
				</p>

				<p style="margin-bottom: 50px;">
					<label>Password:</label>
					<input class="w3-input w3-hover-gray w3-round-large" type="password" name="password">
				</p>

				<div class="w3-bar">
					<input class="w3-bar-item w3-mobile w3-button w3-round-large w3-dark-gray w3-hover-ligh-black" type="submit" name="submit" value="Login" style="margin-right:10px;">
					<a class="w3-bar-item w3-mobile w3-button w3-round-large w3-dark-gray w3-hover-ligh-black" href="SignUp.php" >Sign Up</a>
					<input class="w3-bar-item w3-mobile w3-button w3-round-large w3-dark-gray w3-hover-light-black w3-right" type="reset" value="Reset"/>
				</div>

			</form>

		</div>

	</body>

</html>