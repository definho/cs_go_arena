<?php
require ('steamauth/steamauth.php');
		include('steamauth/userInfo.php');
		include('mysql/mysqlConn.php');
# You would uncomment the line beneath to make it refresh the data every time the page is loaded
$_SESSION['steam_uptodate'] = false;
$steamid=$steamprofile['steamid'];

if(!isset($_SESSION['steamid'])) {
	  
		include('welcome.php'); //login button
    
	}  else {
		$query="select Avatar, Nickname from User WHERE UserID=$steamid";
		$result=mysqli_query($conn, $query);
		$result=mysqli_fetch_assoc($result);
		$avatar=$result['Avatar'];
		$nickname=$result['Nickname'];
		include('editprofile.php'); 
	
		
		}
		
?>  