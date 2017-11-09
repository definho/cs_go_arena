<?php
    include ('steamauth/steamauth.php');
    include('mysql/mysqlConn.php');
    include('steamauth/userInfo.php');
    
     $steamid=$steamprofile['steamid'];
    $lobbyID=$_GET['lobbyID'];
    if($_GET['resultaccept']) {
        
        
        	
        $query1="select UserID1, UserID2, FlagU1, FlagU2 from Lobby WHERE LobbyID=$lobbyID";
		$result1=mysqli_query($conn, $query1);
		$result1=mysqli_fetch_assoc($result1);
       //AKO SAM USER1 UPALI FLAG1
        if ($result1['UserID1']===$steamid) {
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `FlagU1`='1' WHERE `LobbyID`='$lobbyID'");
            if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
            $exec = mysqli_stmt_execute($stmt);
            if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        }
		//AKO SAM USER 2 UPALI FLAG2
        elseif ($result1['UserID2']===$steamid) {
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "UPDATE `Lobby` SET `FlagU2`='1' WHERE `LobbyID`='$lobbyID'");
            if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
            $exec = mysqli_stmt_execute($stmt);
            if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        }
        //AKO SU OBA FLAGA SETANA, BRISEMO LOBBY + OSTALE AKCIJE TRANSFERA ITEMA KASNIJE
        if ($result1['FlagU1']&&$result1['FlagU2']) {
			//UZMI REZULTAT DA UPISES POBJEDU POBJEDNIKU I PORAZ GUBITNIKU
			//UZMI TRENUTNE WINOWE I LOSEVE KORISNIKA TE INKREMENTIRAJ
			$query="select UserID1, UserID2, ScoreU1, ScoreU2 from Lobby WHERE `LobbyID`='$lobbyID'";
			$result=mysqli_query($conn, $query);
			$result = mysqli_fetch_assoc($result);
				$ScoreU1=$result['ScoreU1'];
				$ScoreU2=$result['ScoreU2'];
				$UserID1=$result['UserID1'];
				$UserID2=$result['UserID2'];
			$query="select Wins, Defeats from User WHERE `UserID`='$UserID1'";
			$result=mysqli_query($conn, $query);
			$result = mysqli_fetch_assoc($result);
				$User1wins = $result['Wins'];
				$User1defeats = $result['Defeats'];
			$query="select Wins, Defeats from User WHERE `UserID`='$UserID2'";
			$result=mysqli_query($conn, $query);
			$result = mysqli_fetch_assoc($result);
				$User2wins = $result['Wins'];
				$User2defeats = $result['Defeats'];
			//AKO JE POBJEDNIK U1
			if($ScoreU1>$ScoreU2) {
				$User1wins++;
				$User2defeats++;
				//dodaj pobjede povjedniku
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "UPDATE `User` SET `Wins`='$User1wins' WHERE `UserID`='$UserID1'");
				if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				 $exec = mysqli_stmt_execute($stmt);
				if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
				//dodaj poraze gubitniku
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "UPDATE `User` SET `Defeats`='$User2defeats' WHERE `UserID`='$UserID2'");
				if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				 $exec = mysqli_stmt_execute($stmt);
				if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
				//daj iteme pobjedniku
				$query="select ItemID from Item where `Lobby`='$lobbyID'";
				$result=mysqli_query($conn, $query);
					while ($row=mysqli_fetch_row($result)) {
						$itemid=$row[0];
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, "UPDATE `Item` SET `Owner`='$UserID1', `Lobby`='NULL' WHERE `ItemID`='$itemid'");
						if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
						$exec = mysqli_stmt_execute($stmt);
						if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
					}
					
			}
			//AKO JE POBJEDNIK U2
			elseif($ScoreU1<$ScoreU2) {
				$User2wins++;
				$User1defeats++;
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "UPDATE `User` SET `Defeats`='$User1defeats' WHERE `UserID`='$UserID1'");
				if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				 $exec = mysqli_stmt_execute($stmt);
				if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
				
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, "UPDATE `User` SET `Wins`='$User2wins' WHERE `UserID`='$UserID2'");
				if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				 $exec = mysqli_stmt_execute($stmt);
				if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
				
				$query="select ItemID from Item where `Lobby`='$lobbyID'";
				$result=mysqli_query($conn, $query);
					while ($row=mysqli_fetch_row($result)) {
						$itemid=$row[0];
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, "UPDATE `Item` SET `Owner`='$UserID2', `Lobby`='NULL' WHERE `ItemID`='$itemid'");
						if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
						$exec = mysqli_stmt_execute($stmt);
						if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
					}
			}
			//AKO JE XX pola itema daj jednom, pola itema daj drugom
			elseif($ScoreU1==$ScoreU2) {
				$evenodd=1;
				$query="select ItemID from Item where `Lobby`='$lobbyID'";
				$result=mysqli_query($conn, $query);
					while ($row=mysqli_fetch_row($result)) {
						$itemid=$row[0];
						$stmt = mysqli_stmt_init($conn);
						if($evenodd) {
							mysqli_stmt_prepare($stmt, "UPDATE `Item` SET `Owner`='$UserID2', `Lobby`='NULL' WHERE `ItemID`='$itemid'");
							$evenodd=0;
						}
						elseif (!$evenodd) {
							mysqli_stmt_prepare($stmt, "UPDATE `Item` SET `Owner`='$UserID1', `Lobby`='NULL' WHERE `ItemID`='$itemid'");
							$evenodd=1;
						}
						if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
						$exec = mysqli_stmt_execute($stmt);
						if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
					}
			}
			//NA KRAJU IZBRISI
            $stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "DELETE FROM Lobby WHERE LobbyID=$lobbyID");
			if ($stmt === false) trigger_error('Statement failed! ' . htmlspecialchars(mysqli_error($conn)), E_USER_ERROR);
				
			$exec = mysqli_stmt_execute($stmt);
			if ($exec === false) trigger_error('Statement execute failed! ' . htmlspecialchars(mysqli_stmt_error($stmt)), E_USER_ERROR);
        }
	}
        
         header("Location: index.php"); //na kraju redirectamo
?>