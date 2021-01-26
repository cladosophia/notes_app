<?php
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Notes</title>
    <link rel="icon" href="../img/note.png">
    <link rel="stylesheet" type="text/css" href="../css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        
        <div class="login-content">
            <form id="loginform" class="form-horizontal" role="form" action="../php/login.php" method="POST">
                <img src="../img/a.png">
                <h2 class="title">L O G  I N</h2>
              <?php
                if(@$_GET['Empty']==true)
                {
              ?>
              <p class="txt_error"> <?php echo $_GET['Empty'] ?>  </p>
                                                                 
              <?php
                }
              ?>
              <?php 
                if(@$_GET['Invalid']==true)
                {
              ?>
              <p class="txt_error"> <?php echo $_GET['Invalid'] ?>  </p>
            
                                              
              <?php
                }
              ?>
              
                <div class="input-div one">
                   <div class="i">
                        <i class="fas fa-user"></i>
                   </div>
                   <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="username">
                   </div>
                </div>
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password">
                   </div>
                </div>
                <a href="#">Forgot Password?</a>
                <input type="submit" class="btn" value="ENTER" name="Login">
                <p class="txt_signup"> New User? <a class="txt_signup" href="signup.php">Sign up.</a> </p>
                
            </form>
        </div>
    </div>
    <script type="text/javascript" src="../js/main.js"></script>
</body>
</html>
