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
                    
                    <li><a class="selected" href="index.php">home</a></li>
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
				$query="select LobbyID, UserID1, UserID2, ScoreU1, ScoreU2, FlagU1, FlagU2 from Lobby";
				$result=mysqli_query($conn, $query);
				$lobbyList = array();
				$key=0;
				while ($row = mysqli_fetch_assoc($result)) {
					$lobbyList[$key++]=array($row['UserID1'], $row['UserID2'], $row['LobbyID'], $row['ScoreU1'], $row['ScoreU2'], $row['FlagU1'], $row['FlagU2']);
				}//spremamo rezultat u dvodimenzionalno polje,echo $lobbyList[0][0] ispisuje prvi lobi i userid1
				
				
				
				foreach ($lobbyList as $i => $value_i) { //i je kljuc elementa 0 1 2 3 .. // 
					if(($lobbyList[$i][0]===$steamid)||($lobbyList[$i][1]===$steamid)) {  //ovo polje lobija mozemo iskoristiti za izlistavanje 
						$korisnikovLobby=$lobbyList[$i][2]; //kad smo otkrili u kojem je redu korisnik samo spremimo u variajblu njegov lobby
						$lobbyKey=$i; //samo za provjeru dal je lobby pun
						$lobbyFlag=1;
						break;
					}
					$lobbyFlag=0;
				}
			?>
				<div class="welcomeMessage">
					<p>Welcome back <?php echo $nickname?>.</p>
				</div>
				
				<div class="userStats">
					<table style="width:80%">
						<tr>
							<td>WINS</td>
							<td>LOSE</td>		
							<td>W/L RATIO</td>
							<td>ITEMS COLLECTION</td>
						</tr>
						<tr>
							<td><?php echo $wins;?></td>
							<td><?php echo $defeats;?></td>		
							<td><?php echo ($wins/$defeats);?></td>
							<td>50</td>
						</tr>

					</table>
				</div>
				
				<div class="lobby">
				<?php
				if($lobbyFlag==0) { //OPCIJE AKO KORISNIK NEMA LOBBY
					echo '<div id="createLobby">';
					echo '<button id="createButton" class="button">CREATE MY LOBBY</button>';
					echo '<div class="lobbyDropdown">'; //!!!!!!!!!!!!!!!!!!!PAZITI JER JE OVO NOVI DIV U HTMLU
					
					//MOZE OTVORITI SVOJ + JOIN SE NASTAVLJA U BOXU 2
					echo '<br>';
					echo '<form action="createLobby.php" method="post">'; //OVO JE FORMA KOJA SADRZI CHECKBOXEVE I NA DNU CREATE LOBBY TIPKU
					//ISPIS ULOGA KOJI KORISNIK MOZE ULOZITI
					$steamid = $steamprofile['steamid'];
					$api= "http://steamcommunity.com/profiles/$steamid/inventory/json/730/2";
					$json=file_get_contents($api);
					$inventory= json_decode($json, true);
					foreach ($inventory['rgDescriptions'] as $i => $value_i) {
		
						if($inventory['rgDescriptions'][$i]['tradable']) {
							foreach ($inventory['rgInventory'] as $j => $value_j) {
								if($inventory['rgInventory'][$j]['classid']==$inventory['rgDescriptions'][$i]['classid']) {
									$count++;
								}
							}
							for ($j = $count; $j > 0; $j--) {
								echo '<div class="thumb">
										<img class="img" src="http://cdn.steamcommunity.com/economy/image/'.$inventory['rgDescriptions'][$i]['icon_url'].'" alt="Smiley face" height="60" widht="60"/>
										<input type="checkbox" class="chk" name="item[]" value="http://cdn.steamcommunity.com/economy/image/'.$inventory['rgDescriptions'][$i]['icon_url'].'" />
										</div>';
							}
						}
						unset($count);
			
					}
					//TIPKA ZA IZRADU LOBIJA
					echo '<br><input id="phpCreateLobby" class="button" type="submit" value="GO!">
									</form>';
					//ZATVARAMO TAG DIV-A				
					echo '</div>';//lobbyDropdown
					echo '</div>';//createLobby
				}
				
				if($lobbyFlag==1) {//OPCIJE AKO IMA LOBBY
					$queryL="select UserID1, UserID2 from Lobby WHERE LobbyID=$korisnikovLobby";
					$resultL=mysqli_query($conn, $queryL);
					$resultL=mysqli_fetch_assoc($resultL);
						$USER1=$resultL['UserID1'];
						$USER2=$resultL['UserID2'];
					$queryL="select Nickname, Avatar from User WHERE UserID=$USER1";
					$resultL=mysqli_query($conn, $queryL);
					$resultL=mysqli_fetch_assoc($resultL);
						$USER1NICK=$resultL['Nickname'];
						$USER1AVATAR=$resultL['Avatar'];
					$queryL="select Nickname, Avatar from User WHERE UserID=$USER2";
					$resultL=mysqli_query($conn, $queryL);
					$resultL=mysqli_fetch_assoc($resultL);
						$USER2NICK=$resultL['Nickname'];
						$USER2AVATAR=$resultL['Avatar'];
						
					echo '<div id=USER1>';//USER 1 DIV
					echo '<img id="user1avatar" class="img" src="'.$USER1AVATAR.'"  height="100" widht="100"/>';
					echo '<p id="user1nick">'.$USER1NICK.'</p>';
					echo '<p id="user1res">'.$lobbyList[$lobbyKey][3].'</p>';
					echo '</div>';//KRAJ USER 1 DIV
					
					echo '<div id=USER2>';//USER 2 DIV
					echo '<img id="user2avatar" class="img" src="'.$USER2AVATAR.'"  height="100" widht="100"/>';
					echo '<p id="user2nick">'.$USER2NICK.'</p>';
					echo '<p id="user2res">'.$lobbyList[$lobbyKey][4].'</p>';
					echo '</div>';//KRAJ USER 2 DIV
					
					echo '<div id="USER12">';//ZAJEDNICKI DIV
					echo '	<form id="resultApply" action="insertResult.php" method="get">
							ENTER NEW RESULT: 
							<input class="textbox" type="number" name="ScoreU1" min="0" max="16" size="2"> :
							<input class="textbox" type="number" name="ScoreU2" min="0" max="16" size="2">
							<input type="hidden" name="lobbyID" value="'.$lobbyList[$i][2].'">
							<input class="button" type="submit" value="CONFIRM">
							</form>';
					echo   '<form action="acceptResult.php" method="get">
										
										<input type="hidden" name="resultaccept" value="1">
										<input type="hidden" name="lobbyID" value="'.$lobbyList[$i][2].'">
										<input class="button" type="submit" value="ACCEPT RESULT">
									</form>';
						//delete se pokazuje samo ako je u lobbyusamo on				
					if((!$lobbyList[$lobbyKey][0])||(!$lobbyList[$lobbyKey][1])) {
						echo   '<form action="deleteLobby.php" method="get">
										
										<input type="hidden" name="lobbydelete" value="moj">
										<input class="button" type="submit" value="DELETE LOBBY">
									</form>';
					}
					echo '</div>';
					
					echo '<div id="award">';//AWARD DIV
					echo 'LOBBY '.$korisnikovLobby.' AWARD:<br>';
					$query3="select URL from Item where `Lobby`='$korisnikovLobby'";
					$result3=mysqli_query($conn, $query3);
					while ($row3=mysqli_fetch_row($result3)) {
						$items[]=$row3[0];
					
					}
					foreach ($items as $i => $value_i) {
					echo '<div class="thumb">
						<img class="img" src="'.$items[$i].'" alt="Smiley face" height="60" widht="60"/>
						</div>';
					}
					echo '</div>';
				}
				?>
				</div>
			</div>
		   
		   <div class="box2">
				<div id="joinDropdown">
				<?php
				echo '<form action="joinLobby.php" method="get">';
				$api= "http://steamcommunity.com/profiles/$steamid/inventory/json/730/2";
					$json=file_get_contents($api);
					$inventory= json_decode($json, true);
					foreach ($inventory['rgDescriptions'] as $i => $value_i) {
		
						if($inventory['rgDescriptions'][$i]['tradable']) {
							foreach ($inventory['rgInventory'] as $j => $value_j) {
								if($inventory['rgInventory'][$j]['classid']==$inventory['rgDescriptions'][$i]['classid']) {
									$count++;
								}
							}
							for ($j = $count; $j > 0; $j--) {
								echo '<div class="thumb">
										<img class="img" src="http://cdn.steamcommunity.com/economy/image/'.$inventory['rgDescriptions'][$i]['icon_url'].'" alt="Smiley face" height="30" widht="30"/>
										<input type="checkbox" class="chk" name="item[]" value="http://cdn.steamcommunity.com/economy/image/'.$inventory['rgDescriptions'][$i]['icon_url'].'" />
										</div>';
							}
						}
						unset($count);
			
					}
					echo	'<input id="hiddenJoin" type="hidden" name="lobbyID" value="">
										<input id="phpJoin" class="button" type="submit" value="">
										</form><br><br>';
				?>
				</div>
			<?php
			//OPCIJA ZA JOIN U NEKI OD LOBBIJA
			if($lobbyFlag==0) {
				foreach ($lobbyList as $i => $value_i) {
					if(!$lobbyList[$i][1]) {
						$lobbyopener = $lobbyList[$i][0];
						$lobbyforthumb = $lobbyList[$i][2];
						$query7="select Avatar, Nickname from User WHERE `UserID`='$lobbyopener'";
						$result7=mysqli_query($conn, $query7);
						$result7= mysqli_fetch_assoc($result7);
						echo '<div class="joinlobbyThumbnail">';
						
						echo '<img id="joinlobbyAvatar" src="' . $result7['Avatar']. '" width="40" height="40"/>';
						$query6="select URL from Item where `Lobby`='$lobbyforthumb'";
						$result6=mysqli_query($conn, $query6);
						while ($row3=mysqli_fetch_row($result6)) {
							$items[]=$row3[0];
						}
						echo '<div id="lobbyworth">';
						foreach ($items as $j => $value_j) {
						echo '<div class="thumbL">
							<img class="img" src="'.$items[$j].'" alt="Smiley face" height="10" width="10"/>
							</div>';
						}
						echo '</div>';
						echo '<button class="joinButton" id="'.$lobbyList[$i][2].'"  value="'.$lobbyList[$i][2].'">Challenge '.$result7['Nickname'].'
								</button>';
						echo '</div>';
					}
					}
			}
			else {
				echo '  <p>Please name demo LobbyID_demo.dem, so admins can review your case</p>
						<br>
						
						<form action="demoupload.php" method="post" enctype="multipart/form-data"> 
						<input type="file" name="myFile">
						<br>
						<br>
						<input class="button" type="submit" value="UPLOAD DEMO">
						</form>
						<br>
						<br>
						
						';
						
			}
			?>
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
			var toggleVar1=0;
			$(document).ready(function(){
				$("#createButton").click(function(){
					$(".lobbyDropdown").toggle("slow" );
					if (toggleVar==0) {
						document.getElementById("createButton").innerHTML = "CHANGED MY MIND";
						toggleVar=1;
					}
					else {
						document.getElementById("createButton").innerHTML = "CREATE LOBBY";
						toggleVar=0;
					}
				});
				
				$('.joinButton').click(function() {
					var lobbyid = $(this).attr("value");
					$("#joinDropdown").toggle("slow" );
					$(function () {
						$('#hiddenJoin').val(lobbyid);
					});
					$(function () {
						$('#phpJoin').val("GO("+lobbyid+")");
					});
					if (toggleVar1==0) {
						
						toggleVar1=1;
					}
					else {
						
						toggleVar1=0;
					}
				});
			});

			
			
        </script>
    
    </body>
</html>

