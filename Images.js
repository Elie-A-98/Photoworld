var images = document.getElementsByClassName ("image");

var modal_image_div ; // initialized when modal is opened
var modal_image_index = 0 ;
var modal_image_animation ;

var title;
var description;
var comments;

var comment_modal = document.getElementById ("comment_modal");
var comment_form = document.getElementById ("comment_form");
var current_image_id;

var is_modal_open = false ;

window.addEventListener ("resize", function (e) {
	if (is_modal_open){
		CloseModal () ;
		OpenModal (0);
	}
});

comment_form.addEventListener ("submit", function (e){
	e.preventDefault ();
	
	var xhttp = new XMLHttpRequest () ;
	var data = new FormData (comment_form);

	var comment = data.get("comment");

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200 ){
			UpdateCommentSection (current_image_id, true);
			CloseCommentModal ();
		}
	}

	xhttp.open ("POST", "add_comment.php", true);
	xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("image_id="+current_image_id+"&comment="+comment);

});

function OpenCommentModal (){
	AddTouchHandlers () ;
	comment_modal.style.display = "block";
}

function CloseCommentModal (){
	RemoveTouchHandlers () ;
	comment_modal.style.display = "none";
}

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

function LikeClicked (comment_id) {
	var xhttp = new XMLHttpRequest () ;

	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200){
			UpdateCommentSection (current_image_id, false);
		}
	}

	xhttp.open ("POST", "like_comment.php", true);
	xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");
	xhttp.send ("comment_id="+comment_id);
}

function RemoveLikeClicked (comment_id){
	var xhttp = new XMLHttpRequest () ;

	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200){
			UpdateCommentSection (current_image_id, false);
		}
	}

	xhttp.open ("POST", "unlike_comment.php", true);
	xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");
	xhttp.send ("comment_id="+comment_id);
}

function ShowImage (index){

	var div = document.createElement ("div");
	var img = document.createElement ("img");

	div.classList.add ("w3-display-container", modal_image_animation);
	div.style.width = "100%";
	div.style.height = "100%";
	
	img.src = images[index].src ;
	img.dataset.image_id = images[index].dataset.image_id;
	
	img.classList.add ("w3-display-middle");
	img.style.maxWidth = "100%";
	img.style.maxHeight = "100%";

	div.appendChild (img);
	
	modal_image_div.innerHTML = "";
	modal_image_div.appendChild (div);

	UpdateCommentSection (img.dataset.image_id, true);
	current_image_id = img.dataset.image_id;

}

function UpdateCommentSection (image_id, animated){
	
	// Update header (TITLE) and (DESCRIPTION)

	var xhttp = new XMLHttpRequest () ;

	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200){
			var obj = JSON.parse (this.responseText);
			
			if (obj.title == ""){
				obj.title = "No title";
			}
			
			if (obj.description == ""){
				obj.description = "No description";
			}
			title.innerHTML = obj.title;
			description.innerHTML = obj.description;

			// alert ("Title: " + obj.title);
		}
	};

	xhttp.open ("POST","get_title_description.php", true);
	xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");
	xhttp.send ("image_id="+image_id) ;
	

	//UPDATE COMMENTS

	xhttp = new XMLHttpRequest () ;
	xhttp.onreadystatechange = function () {
		if ( this.readyState == 4 && this.status == 200){
			comments.innerHTML = this.responseText;
		}
	}

	xhttp.open ("POST", "get_comment.php", true);
	xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");
	xhttp.send ("image_id="+image_id+"&count=2&animate="+animated);

}

function OpenModal (index){
	AddTouchHandlers () ;

	modal_image_div = document.getElementById ("modal_images_div_1");

	var modal_list = document.querySelectorAll (".modal_x");
	for (let i = 0 ; i < modal_list.length; i ++){
		if (getComputedStyle(modal_list[i]).display != "none"){
			// alert (getComputedStyle(modal_list[i]).display);
			if (i == 0){
				modal_image_div = document.getElementById ("modal_images_div_1");
				comments = document.getElementById ("comments_1");
				title = document.getElementById ("title_1");
				description = document.getElementById ("description_1");
				break;
			}else {
				modal_image_div = document.getElementById ("modal_images_div_2");
				comments = document.getElementById ("comments_2");
				title = document.getElementById ("title_2");
				description = document.getElementById ("description_2");
			}
		}
	}

	modal = document.getElementById("home_modal");
	modal.style.display = "block";

	modal_image_index = index ;
	modal_image_animation = "w3-animate-opacity";

	ShowImage (index);

	is_modal_open = true ;
}

function CloseModal (){
	RemoveTouchHandlers () ;

	modal = document.getElementById("home_modal");
	modal.style.display = "none";

	is_modal_open = false ;
}

function SwipeLeft (){
	ChangeIndex (-1);
}

function SwipeRight (){
	ChangeIndex (1);
}

function SwipeUp (){
	document.getElementById("mobile_comments").classList.remove("w3-hide");
	document.getElementById("mobile_comments").classList.add("w3-show");
}

function SwipeDown (){
	document.getElementById("mobile_comments").classList.remove("w3-show");
	document.getElementById("mobile_comments").classList.add("w3-hide");
}