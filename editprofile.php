<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title> RWA projekt </title>
        
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        
        <script src="http://code.jquery.com/jquery-2.1.4.js"></script>
           
        
    </head>
    
    <body>
        
        <div class="header">
            <div class="top">
                
                <div id="comercial">
                    <img id="monster" src="comercial/monster.png" alt="monster">
                    <img id="steelseries" src="comercial/steelseries.png" alt="steelseries">
                    <img id="eizo" src="comercial/eizo.png" alt="eizo">
                    <img id="razer" src="comercial/razer.png" alt="razer">
                    <img id="roccat" src="comercial/roccat.png" alt="roccat">
                    
                    
                </div>
            </div>
            <div class="nav">
                <div id="logoutButton">
                    <?php echo logoutbutton(); ?>
                </div>
				<div id="logo">
					<?php
					echo '<img src="' . $avatar . '" width="60" height="60"/>';//probe radi
					?>
				</div>
            </div>
			<div class="tabs">
                <ul>
                    <li><a class="selected" href="edit.php">profile</a></li>
                  
                    <li><a href="index.php">home</a></li>
					<?php
					$queryA="select Admin from User where UserID=$steamid";
					$resultA=mysqli_query($conn, $queryA);
					$resultA=mysqli_fetch_assoc($resultA);
					$admin=$resultA['Admin'];
					if($admin) echo '<li><a href="admin.php">admin</a></li>';
					?>
                </ul>
            </div>
        </div>
        
        <div class="content">
			
           <div class="box1">
				<?php
				$queryE="select Nickname, Avatar from User WHERE UserID=$steamid";
					$resultE=mysqli_query($conn, $queryE);
					$resultE=mysqli_fetch_assoc($resultE);
						$USER1NICKE=$resultE['Nickname'];
						$USER1AVATARE=$resultE['Avatar'];
						echo '<img id="avatarE" class="img" src="'.$USER1AVATARE.'" alt="Smiley face" height="100" widht="100"/>';
						echo '<p id="nickE">'.$USER1NICKE.'</p>';
				?>
				
                <form id="profilesubmit" action="upload.php" method="post" enctype="multipart/form-data">
                	New Avatar:&nbsp&nbsp<input id="newavatarinput" type="file" name="fileToUpload" id="fileToUpload"><br>
					New Nickname:&nbsp&nbsp<input class="textbox" type="text" name="Nick"><br><br>
								<input class ="button" type="submit" value="SUBMIT NEW YOUR NEW ALIAS">
                </form>
				
		   </div>
		   
		   <div class="box2">
			<div class="inventory">
				<p>ITEM COLLECTION:</p><BR>
				<?php
				$query3="select URL from Item where `Owner`='$steamid'";
				$result3=mysqli_query($conn, $query3);
					while ($row3=mysqli_fetch_row($result3)) {
						$items[]=$row3[0];
					
					}
					foreach ($items as $i => $value_i) {
					echo '<div class="thumb">
						<img class="img" src="'.$items[$i].'" alt="Smiley face" height="60" widht="60"/>
						</div>';
					}
					?>
				</div>
		   </div>
		   
		</div>
        
		<script>
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                
                if (scroll==0) {
                    $(".header").removeClass("headerUp");
                    $(".content").removeClass("contentUp");
                } else {
                    $(".header").addClass("headerUp");
                    $(".content").addClass("contentUp");
                }
                
                });
			var toggleVar=0;
			$(document).ready(function(){
				$("button").click(function(){
					$(".createLobby").toggle("slow" );
					if (toggleVar==0) {
						document.getElementById("createButton").innerHTML = "CHANGED MY MIND";
						toggleVar=1;
					}
					else {
						document.getElementById("createButton").innerHTML = "CREATE LOBBY";
						toggleVar=0;
					}
				});
			});
        </script>
    
    </body>
</html>

