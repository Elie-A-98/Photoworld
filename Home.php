<?php
session_start ();

require "Database/Connection.php";

if ($connected == false) goto render ;

$isUser = isset ($_SESSION["id"]);
$isSubmit = isset ($_POST["submit"]);
$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

$id ;
$username ;
$user_settings ;

$images ;

if ($isUser) {
	$id = $_SESSION["id"];
	
	if ($isPost){

		extract ($_POST);
		extract ($_FILES);

		if ($isSubmit && $submit =="Upload"){

			if (isset($title)) {		// title  will always be set but maybe empty because it is a textbox
				if ( isset ($url) && !empty ($url)){	// textboxes are always set but return empty if not filled when posting

					if (!empty ($title) && !empty ($url)) {
						InsertImage ($id, $title, $url, $description,"", false);
					}

					
				}else if (!empty ($file_to_upload["tmp_name"])) {

					$checkImage = true ;

					$isImage = getimagesize ($file_to_upload["tmp_name"]);  // getimagesize is not trusted --> CHANGE IT
					$imageType = strtolower (pathinfo($file_to_upload["name"],PATHINFO_EXTENSION)); // Get file extension (jpg, jpeg, ...)

					if ( !$isImage || $imageType != "jpg" && $imageType != "jpeg" && $imageType != "png" && $imageType != "gif"){
						$checkImage = false ;
					}

					if ($checkImage) {
						InsertImage ($id, $title, "", $description, $file_to_upload, true);
						$file_to_upload = NULL;
					}
				}
			}
			
		}

		if ($isSubmit && $submit =="Save"){
			changeImageSectionColor ($id, $image_section_color);
		}
	}

    $user = getCurrentUser ($id);
    $username = mysqli_fetch_assoc ($user)["name"];
	$images = getUserImages ($id);
	$user_settings = mysqli_fetch_assoc (getUserSettings ($id)) ;

}else {
    header ("Location:Login.php");
}



render :
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
<?php include "Navigation.php"; ?> 

<div id="content" class="w3-animate-opacity">

    <!-- Upload Picture Section -->
    <div class ="w3-container w3-center" style="margin-bottom:75px;">

        <div style="margin-bottom:50px;">
            <h1>Upload Your picture<h1>
        </div>

        <form class ="w3-large" enctype="multipart/form-data" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">

            <div class ="w3-row-padding" style="margin-bottom:75px;">

                <div class ="w3-third" style="margin-bottom:10px;" >
                    <div class ="w3-cell-row">
                        <div class="w3-cell w3-cell-middle">
                            Title:
                        </div>

                        <div class="w3-cell" >
                            <input type ="text" class="w3-input" name ="title">
                        </div>
                    </div>
                </div>

                <div class ="w3-third" style="margin-bottom:20px;">
                    <div class ="w3-cell-row">
                        <div class="w3-cell w3-cell-middle">
                            URL:
                        </div>

                        <div class="w3-cell">
                            <input type ="text" class="w3-input" name ="url">
                        </div>
                    </div>

                </div>

                <div class ="w3-third" >
                    <div class ="w3-cell-row" >
                        <div class="w3-cell " >
                            Description:
                        </div>
                        <div class="w3-cell">
                            <textarea class="w3-input" rows="2" style="font-style:italic;" name="description">Enter description here</textarea>
                        </div>
                    </div>
                </div>
        
			</div>
			
			<div class="w3-cell-row" style = "margin-bottom:100px;">
				
				<input id="browse" type="file" name="file_to_upload" value="" style="display:none;">

				<label for ="browse" class="w3-btn w3-light-gray w3-round-xxlarge w3-border-gray w3-leftbar w3-rightbar w3-topbar w3-bottombar" style="padding:10px;">
					<i class="material-icons" style= "font-size:40px;vertical-align: middle;margin-right:5px;">file_upload</i>
					Browse for an image
				</label>

			</div>

            <input type="submit" class="w3-btn w3-round-xxlarge" style="background-color:rgb(210, 210, 210);" name="submit" value ="Upload">
        </form>
		
			
		
    </div>
    

    
    <!-- Images section -->
	<div>

		<hr>
		<!-- Section styler (right and left)-->
		<div style = "position:relative;">

			<div class="w3-center w3-mobile" style="margin-bottom:50px;">
				<h2>My pictures<h2>
			</div>

			<form class="w3-hide-medium w3-hide-small" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<div style="position:absolute;top:0;width:100%;">
					<div class="w3-right">
						<h4>Background color: <input class="w3-circle w3-hover-yellow" type="color" name="image_section_color">
						<input class="w3-btn w3-hover-black w3-margin-left w3-round-xlarge" style="background-color:rgb(185, 185, 185);" type="submit" name="submit" value="Save">
					</div>
					
					<div class="w3-left">
						<h4> <button class="w3-btn w3-round-xxlarge w3-hover-purple w3-margin-left" style="background-color:rgb(185, 185, 185);">Start SlideShow </button>
						</h4>
					</div>
				</div>
			
			</form>

			<form class="w3-hide-large" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<div class="w3-center">
					<h4>Background color: <input class="w3-circle w3-hover-yellow" type="color" name="image_section_color">
					<input class="w3-btn w3-hover-black w3-margin-left" style="background-color:rgb(185, 185, 185);" type="submit" name="submit" value="Save">
				</div>
					
				<div class="w3-center">
					<h4> <button class="w3-btn w3-round-xxlarge w3-hover-purple w3-margin-left" style="background-color:rgb(185, 185, 185);">Start SlideShow </button>
					</h4>
				</div>
			
			</form>

		</div>
		<hr>

		<!-- Images -->
		<div style = "position:relative;">

			<div class = "images_background" style="background-color:<?php echo $user_settings['image_section_color']?>;"></div>

			<div>
				<?php
					function AddRow () {
						echo "<div class ='w3-row-padding'>";
					}
					function EndRow () {
						echo "</div>";
					}
					
					function AddImage ($path,$title,$index) {
						echo "<div class ='w3-third w3-center w3-padding w3-hover-sepia' onclick='OpenModal($index)'>
								<img class='image w3-animate-top' src ='$path' style='width:100%'></img>
							</div>";
					}

					$i = 0;
					while ($row = mysqli_fetch_assoc ($images)){
						if ($i % 3 == 0){
							if ($i > 0) EndRow ();
							AddRow ();
						}

						AddImage ($row["location"],$row["title"],$i);

						$i++;
					}
					EndRow () ;
					
				?>
			</div>
			
		
		</div>
		
	
	</div>
	<!-- End Image Section -->


	<!-- Modal -->
	<div id ="home_modal" class ="w3-modal" style="z-index:20;">
		<!-- for LARGE screens-->
		<div id="modal_1" class ="w3-hide-medium w3-hide-small w3-cell-row w3-display-middle" style="width:90%;height:90%;">
			
			<div class ="w3-cell w3-cell-middle w3-animate-left" >
				<button class="w3-button w3-light-gray" onclick="ChangeIndex(-1)">&#10094;</button>
			</div>

			<div class ="w3-cell w3-cell-middle w3-animate-top " style="z-index:-1;width:100%;height:100%;">

				<div class ="w3-modal-content w3-display-container" style="width:100%;height:100%;">
					
					<div id="modal_images_div_1" style ="width:70%; height:100%; background-color:black">first </div>
					
					<!-- Comment Section -->
					<div class="w3-display-topright w3-display-container" style="width:30%; height:100%; background-color:red;">
						<div class ="w3-display-topright">
							<span class="w3-animate-top w3-button" style="font-size:40px;" onclick = "CloseModal()">&times;</span>
						</div>
						ASDASDASDASDSADASDASDASDASDSADSADASDWASDASDASDASD
					</div>
					<!-- END COMMENT SECTION -->

				</div>

			</div>

			<div class ="w3-cell w3-cell-middle w3-animate-right">
				<button class="w3-button w3-light-gray" onclick="ChangeIndex(1)">&#10095;</button>
			</div>

		</div>

		<!-- for SMALL and MEDIUM screens-->
		<div id ="modal_2" class ="w3-hide-large w3-display-middle" style="width: 95%; height:95%;">

			<div class= "w3-modal-content w3-display-container w3-animate-left" style="width:100%;height:100%;background-color:black;">
				<div id="modal_images_div_2" class="w3-display-middle" style ="width:100%; height:100%;"> 
					
				</div>

				<div class ="w3-display-topright">
					<span class="w3-animate-left w3-button w3-text-white" style="font-size:40px;" onclick = "CloseModal()">&times;</span>
				</div>

			</div>

		</div>
	</div>
	<!-- End Modal -->
	

</div>



<script src = "NavScript.js" type="text/javascript"></script>
<script src = "PhoneScript.js" type="text/javascript"></script>

<script type="text/javascript">

var images = document.getElementsByClassName ("image");

var modal_image_div ; // initialized when modal is opened
var modal_image_index = 0 ;
var modal_image_animation ;

function ChangeIndex (x){
	
	if (x < 0){
		modal_image_animation = "w3-animate-right";
	}else {
		modal_image_animation = "w3-animate-left";
	}

	modal_image_index += x ;
	if (modal_image_index < 0) modal_image_index = images.length-1;
	modal_image_index = modal_image_index % images.length;

	ShowImage (modal_image_index);
}

function ShowImage (index){

	var div = document.createElement ("div");
	var img = document.createElement ("img");

	div.classList.add ("w3-display-container", modal_image_animation);
	div.style.width = "100%";
	div.style.height = "100%";
	
	img.src = images[index].src ;
	
	img.classList.add ("w3-display-middle");
	img.style.maxWidth = "100%";
	img.style.maxHeight = "100%";

	div.appendChild (img);
	
	modal_image_div.innerHTML = "";
	modal_image_div.appendChild (div);

}

function OpenModal (index){
	AddTouchHandlers () ;

	modal_image_div = document.getElementById ("modal_images_div_1");

	modal = document.getElementById("home_modal");
	modal.style.display = "block";

	modal_image_index = index ;
	modal_image_animation = "w3-animate-opacity";
	ShowImage (index);
}

function CloseModal (){
	RemoveTouchHandlers () ;

	modal = document.getElementById("home_modal");
	modal.style.display = "none";
}

function SwipeLeft (){
	ChangeIndex (-1);
}

function SwipeRight (){
	ChangeIndex (1);
}

function SwipeUp (){
	
}

function SwipeDown (){
	
}

</script>

</body>

</html>