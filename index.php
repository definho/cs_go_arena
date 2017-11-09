<?php
require ('steamauth/steamauth.php');  
# You would uncomment the line beneath to make it refresh the data every time the page is loaded
$_SESSION['steam_uptodate'] = false;


if(!isset($_SESSION['steamid'])) {
	  
		include('welcome.php'); //login button
    
	}  else {
		
		
		include('steamauth/userInfo.php');
		include('mysql/mysqlConn.php');
		
		$steamid=$steamprofile['steamid'];
		$nickname=$steamprofile['personaname'];
		$avatar=$steamprofile['avatarfull'];
		
		$query = mysqli_query($conn, "SELECT * FROM User WHERE UserID='".$steamid."'");
		$num_rows=mysqli_num_rows($query);
		
		if (!$num_rows) { // provjera postoji li korisnik u bazi i ako ne postoji ga dodamo
			
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "INSERT INTO User (UserID, Nickname, Avatar) VALUES ('$steamid', '$nickname', '$avatar')");
				if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
				$exec = mysqli_stmt_execute($stmt);
				if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);	
				
				}
		$query="select Avatar, Nickname, Wins, Defeats from User WHERE UserID=$steamid";
		$result=mysqli_query($conn, $query);
		$result=mysqli_fetch_assoc($result);
		$avatar=$result['Avatar'];
		$nickname=$result['Nickname'];
		$defeats=$result['Defeats'];
		$wins=$result['Wins'];
		include('htmlLobby.php');
		}
		
?>  
