<?php
    include ('steamauth/steamauth.php');
    include('mysql/mysqlConn.php');
    include('steamauth/userInfo.php');
    
    
    if($_GET['ScoreU1']&&$_GET['ScoreU2']) {
        
        $steamid=$steamprofile['steamid'];
        $lobbyID=$_GET['lobbyID'];
        $score1=$_GET['ScoreU1'];
        $score2=$_GET['ScoreU2'];
        //UPISUJEMO REZ U LOBBY
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `ScoreU1`='$score1', `ScoreU2`='$score2' WHERE `LobbyID`='$lobbyID'");
		if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
		$exec = mysqli_stmt_execute($stmt);
		if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        
        
		//provjeramo dal je trenutni user u1 ili u2 te ovisno o tome dizemo flag da se slaze sa rezultatom		
      	$query1="select UserID1, UserID2 from Lobby WHERE LobbyID=$lobbyID";
		$result1=mysqli_query($conn, $query1);
		$result1=mysqli_fetch_assoc($result1);
        
        if ($result1['UserID1']===$steamid) {
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `FlagU1`='1', `FlagU2`='0' WHERE `LobbyID`='$lobbyID'");
            if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
            $exec = mysqli_stmt_execute($stmt);
            if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        }
        elseif ($result1['UserID2']===$steamid) {
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `FlagU2`='1', `FlagU1`='0' WHERE `LobbyID`='$lobbyID'");
            if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
            $exec = mysqli_stmt_execute($stmt);
            if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        }
        
	}
        
        
        
            
         header("Location: index.php"); //na kraju redirectamo
?>

