<?php
    include ('steamauth/steamauth.php');
    include('mysql/mysqlConn.php');
    include('steamauth/userInfo.php');
    $itemArray=$_GET['item'];
	$steamid=$steamprofile['steamid'];
	$lobbyID=$_GET['lobbyID'];
	if(empty($itemArray)) {//ako nista nije odabrao vrati ga natrag
		header("Location: index.php");
		
	}
	
	else {	// u suprotnom napravi napravi lobby
        $stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `UserID2`='$steamid' WHERE `LobbyID`='$lobbyID';");
		if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
		$exec = mysqli_stmt_execute($stmt);
		if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
	
		//upisi lobbyID u iteme		
		if($itemArray) { //odabrane stvari stavi u bazu bez vlasnika, te mu dodaj pripadajuci lobby
		$n = count($itemArray);
		for($i=0; $i < $n; $i++){//upisujemo ih u bazu
			$item=$itemArray[$i];
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "INSERT INTO Item (URL, Lobby) VALUES ('$item', '$lobbyID')");
				if ($stmt === false) {
				trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
				}
				$exec = mysqli_stmt_execute($stmt);
				if ($exec === false) {
				trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
				}
			
			
			}	
		
		}
	}
        
            
         header("Location: index.php"); //na kraju redirectamo
?>
