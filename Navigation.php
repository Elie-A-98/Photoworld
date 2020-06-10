<!-- HEADER/NAVIGATION -->
<header id ="header_id" class="w3-card-4">

    <!-- LARGE SCREEN -->
    <div class="w3-hide-small w3-hide-medium">

        <div class="w3-opacity w3-center title" style="margin-bottom:60px;">
            <h1><b>PHOTOWORLD</b></h1>
        </div>
        
        <!-- STICKY HEADER -->
        <div id="stickyheader_id" class="normalnavbar">

            <div class = "w3-cell-row w3-opacity">
                <div class="w3-bar w3-cell" style = "width:65%;">
                    <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Home</a>
                    <a href="Users.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Users</a>
                    <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Contact</a>
                    <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">About us</a>
				</div>
				
				<div class = "w3-cell w3-cell-row">
					<div class="w3-cell w3-cell-middle" style = "width:20%;">
						Search User
					</div>

					<div class="w3-cell w3-cell-middle" style = "width:64%;">
						<input class="w3-input" type="text" name="searched_user" style="width:100%;">
					</div>
					
					<div class="w3-cell w3-cell-middle" >
						<button  class="w3-btn w3-round-xxlarge w3-hover-black w3-large">Search</button>
					</div>
				</div> 

                <div class="w3-cell w3-cell-middle w3-dropdown-hover w3-right">
                    <button  class="w3-btn w3-hover-black w3-large"><?php echo $_SESSION ["username"]; ?></button>
                        <div class = "w3-bar-block w3-dropdown-content w3-border" style="right:0;" >
                        <a href ="Home.php" class ="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Account</a>
                        <form method="POST" action ="Login.php">
                            <button class ="w3-bar-item w3-btn w3-hover-black w3-large" name="signout">Sign Out</button>
                        </form>
                        </div>
                </div>
            </div>
        
        </div>

    </div>


    <!-- SMALL/MEDIUM SCREEN  -->
    <div class="w3-opacity w3-hide-large w3-bar" style="width: 100%;">

        <div class ="w3-bar-item">
            <h1><b>PHOTOWORLD</b></h1>
        </div>

        <span class="w3-bar-item w3-right w3-button" onclick ="OpenBars ()">
            <h1><i class="fa fa-bars "></i><h1>
		</span>
		
    </div>
    
    <div class ="w3-hide w3-bar-block w3-hide-large w3-border-left w3-border-bottom w3-animate-opacity" 
         style ="position:absolute;bottom:auto;right:0;z-index:4;background-color: white;" id="bars">
        <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Home</a>
        <a href="Users.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Users</a>
        <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Contact</a>
        <a href="Home.php" class="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">About us</a>
        <a href="Home.php" class ="w3-bar-item w3-mobile w3-btn w3-hover-black w3-large">Account</a>
        <form method="POST" action ="Login.php">
            <button class ="w3-bar-item w3-btn w3-hover-black w3-large" name="signout">Sign Out</button>
        </form>
    </div>
    
</header>

<div class="w3-hide-large w3-hide" onclick ="CloseBars ()" id="overlay"></div>