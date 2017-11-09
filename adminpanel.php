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
                    <li><a href="edit.php">profile</a></li>
                  
                    <li><a href="index.php">home</a></li>
                    <li><a class="selectedAdmin" href="admin.php">admin</a></li>
                </ul>
            </div>
        </div>
        
        <div class="content">
			
           <div class="box1">
				<?php
                $query="select LobbyID, UserID1, UserID2, ScoreU1, ScoreU2, FlagU1, FlagU2 from Lobby";
				$result=mysqli_query($conn, $query);
				$lobbyList = array();
				$key=0;
				while ($row = mysqli_fetch_assoc($result)) {
					$lobbyList[$key++]=array($row['UserID1'], $row['UserID2'], $row['LobbyID'], $row['ScoreU1'], $row['ScoreU2'], $row['FlagU1'], $row['FlagU2']);
				}//spremamo rezultat u dvodimenzionalno polje,echo $lobbyList[0][0] ispisuje prvi lobi i userid1
                foreach ($lobbyList as $i => $value_i) {
					echo '<br>';
                    echo   '<form action="deleteLobby.php" method="get">
								<input type="hidden" name="lobbydelete" value="'.$lobbyList[$i][2].'">
								<input class="button" type="submit" value="DELETE LOBBY '.$lobbyList[$i][2].'">
							</form>';
                    echo '	<form action="insertAdminResult.php" method="get">
							ENTER NEW RESULT FOR LOBBY '.$lobbyList[$i][2].': 
							<input class="textbox" type="number" name="ScoreU1" min="0" max="16" size="2"> :
							<input class="textbox" type="number" name="ScoreU2" min="0" max="16" size="2">
							<input type="hidden" name="lobbyID" value="'.$lobbyList[$i][2].'">
							<input class="button" type="submit" value="CONFIRM">
							</form>';
                    echo   '<form action="acceptBothResult.php" method="get">
										
										<input type="hidden" name="resultaccept" value="1">
										<input type="hidden" name="lobbyID" value="'.$lobbyList[$i][2].'">
										<input class="button" type="submit" value="FINISH CONFLICT FOR LOBBY '.$lobbyList[$i][2].'">
									</form>';
                    echo '<br>';
                }
                ?>
				
		   </div>
		   
		   <div class="box2">
			
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

