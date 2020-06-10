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
			
			function AddImage ($path,$title,$index, $image_id) {
				echo "<div class ='w3-third w3-center w3-padding w3-hover-sepia' onclick='OpenModal($index)'>
						<img class='image w3-animate-top' src ='$path' style='width:100%'  data-image_id ='$image_id'></img>
					</div>";
			}

			$i = 0;
			while ($images != null && $row = mysqli_fetch_assoc ($images)){
				if ($i % 3 == 0){
					if ($i > 0) EndRow ();
					AddRow ();
				}

				AddImage ($row["location"],$row["title"],$i, $row["id"]);

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
	<div id="" class ="modal_x w3-hide-medium w3-hide-small w3-cell-row w3-display-middle" style="width:90%;height:90%;">

	<div class ="w3-cell w3-cell-middle w3-animate-left" >
		<button class="w3-button w3-light-gray" onclick="ChangeIndex(-1)">&#10094;</button>
	</div>

	<div class ="w3-cell w3-cell-middle w3-animate-top " style="z-index:-1;width:100%;height:100%;">

		<div class ="w3-modal-content w3-display-container" style="width:100%;height:100%;">
			
			<div id="modal_images_div_1" style ="width:70%; height:100%; background-color:black">
			</div>
			
			<!-- Comment Section -->
			<div class="w3-display-topright" style="width: 30%; height:100%; overflow:hidden;">

				<!-- View comments -->
				<div style="height: 93%; overflow-y:scroll; overflow-x: hidden;">
					
					<div class ="comment_section_header w3-bottombar w3-animate-zoom w3-border-gray w3-round-large">
						<h3 class="w3-center w3-border-bottom">
							<b id = "title_1"></b>
						</h3>

						<h6 id="description_1"></h6>
					</div>

					<div id ="comments_1">
					</div>

				</div>

				<!-- Add Comment -->
				<div class="w3-display-container w3-card-4" style="height:7%;">
					<button type="button" 
						class="w3-display-middle w3-button w3-round-xxlarge w3-blue w3-hover-light-blue" 
						style="outline: none; font-size:1.5em;"
						onclick="OpenCommentModal ()">
						Add Comment
					</button>
				</div>

			</div>
			<!-- END COMMENT SECTION -->

			
			
		</div>

	</div>

	<div class ="w3-cell w3-display-container w3-animate-right">
		<div class="w3-display-top">
			<span class="w3-button w3-light-gray w3-hover-black" style="font-size:40px;" onclick = "CloseModal()">&times;</span>
		</div>

		<div class ="w3-display-left">
			<button class="w3-button w3-light-gray" onclick="ChangeIndex(1)">&#10095;</button>
		</div>
		
	</div>

	

	</div>

	<!-- for SMALL and MEDIUM screens-->
	<div id ="" class ="modal_x w3-hide-large w3-display-middle" style="width: 95%; height:95%;">

		<div class= "w3-modal-content w3-display-container w3-animate-left" style="width:100%;height:100%;background-color:black;">
			<div id="modal_images_div_2" class="w3-display-middle" style ="width:100%; height:100%;"> 
				
			</div>

			<div class ="w3-display-topright">
				<span class="w3-animate-left w3-button w3-text-white" style="font-size:40px;" onclick = "CloseModal()">&times;</span>
			</div>

			<div id="mobile_comments" class="w3-modal">
				<div class="w3-modal-content" style = "background-color: rgba(233,233,233,0.6);">
					
					<div class="" style="width: 100%; height:100%;">

						<!-- View comments -->
						<div style="height: 80vh; overflow-y:scroll; overflow-x: hidden;">
							
							<div class ="comment_section_header w3-bottombar w3-animate-zoom w3-border-gray w3-round-large">
								<h3 class="w3-center w3-border-bottom">
									<b id = "title_2"></b>
								</h3>

								<h6 id="description_2"></h6>
							</div>

							<div id ="comments_2">
							</div>

						</div>

						<!-- Add Comment -->
						<div class="w3-display-container w3-card-4" style="height:7%;">
							<button type="button" 
								class="w3-display-middle w3-button w3-round-xxlarge w3-blue w3-hover-light-blue" 
								style="outline: none; font-size:1.5em;"
								onclick="OpenCommentModal ()">
								Add Comment
							</button>
						</div>

					</div>

				</div>
			</div>

		</div>

	</div>

	<div class="w3-modal w3-animate-zoom" id="comment_modal" style="z-index: 30;">
		<div class="w3-modal-content w3-display-middle w3-padding w3-round-large w3-card-4">
			<h2 class="w3-center" >  
				Add comment
			</h2>
			<form id="comment_form" class="w3-padding">
				<textarea class="w3-input w3-round-large w3-large w3-blue" rows="4" name="comment" style="outline: none; margin: 0 0 1.5em 0;" ></textarea>
				<button type="submit" class="w3-button w3-margin-top w3-round-xxlarge w3-blue w3-hover-light-blue" style="outline: none;width:100%; font-size:1.5em;">Post</button>
				<button type="button" class="w3-button w3-margin-top w3-round-xxlarge w3-grey" 
					style="outline: none;width:100%; font-size:1.5em;"
					onclick = "CloseCommentModal ()">
					Cancel
				</button>
			</form>
		</div>
	</div>

</div>
<!-- End Modal -->



