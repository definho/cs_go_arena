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
                
                <div id="loginButton">
                    <?php echo steamlogin(); ?>
                </div>
            </div>
            <div class="tabs">
                <ul>
                    <li><a class="selected" href="#1">home</a></li>
                </ul>
            </div>
        </div>
        
        <div class="content">
            <div id="welcomeMessage">
                <p>Hello dear customer, </p><br>
                <p>we would like to welcome you to our beta web application designed for players</p><br>
                <p>who would like to test their skills with other players from whole world</p><br>
                <p>with a goal of increasing their inventory value</p><br>
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
        </script>
    
    </body>
</html>