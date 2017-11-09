<?php
    include ('steamauth/steamauth.php');
    include('mysql/mysqlConn.php');
    include('steamauth/userInfo.php');
    
    
    if($_GET['lobbydelete']==="moj") {//vezano na formu prije
        
			$steamid=$steamprofile['steamid'];
        
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "DELETE FROM Lobby WHERE UserID1=$steamid");
			if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
			$exec = mysqli_stmt_execute($stmt);
			if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);	
				
		}
     elseif($_GET['lobbydelete']) {
		$lobby4delete=$_GET['lobbydelete'];
		
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "DELETE FROM Lobby WHERE LobbyID=$lobby4delete");
		if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
		$exec = mysqli_stmt_execute($stmt);
		if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
		
	 }
        
            
         header("Location: index.php"); //na kraju redirectamo
?>