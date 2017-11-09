<?php
    if(!$_SESSION['steam_id']=="") {
        include("settings.php");
          if (empty($_SESSION['steam_uptodate']) or $_SESSION['steam_uptodate'] == false or empty($_SESSION['steam_personaname'])) {
            $api = "http://api.steampowered.com/IEconItems_{730}/GetPlayerItems/v0001/?key={apikey}&steamid={steamid}&format=json";
            $json = file_get_contents ($api);
            $inventory = json_decode($json);
            print var_dump($inventory);
        }
    }
?>