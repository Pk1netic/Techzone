<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <?php
        //starting a session. This will be needed to enable all sessions to functions on this page
        session_start();
        //including the header
        include_once 'PhpScripts/Header.php'; 
        //including createsession script. Used to check if unauthenticated user has a session if not creating one to identify them.
        include_once 'PhpScripts/CreateSession.php';
        //including the destroy session script to destroy the unauthenticated user's session if they've been inactive for 30 minutes.
        include_once 'PhpScripts/DestroySession.php';
        //including the script for this webpage
        include_once 'PhpScripts/LoginScript.php';
        ?>

        <!--The form was made from scratch. Only the container class/style was unoriginal aswell as the submit button as it was produced by bootstrap.
        The container was included to ease the process of making the webpage responsive.-->
        <div class="formcontainer container form">    
            <h1 class="align-center">Login</h1>
            <form action = "Login.php" method="post">
                <label for="email">Email<span>*</span></label><br>
                <input id="Email_Address" type="email" required="" name="email" class="input-box">
                
                <label for="password">Password<span>*</span></label><br>
                <input id="password" type="password" required="" name="password" class="input-box">
                
                <div class="align-center">
                    <input type ="submit" name="login" value="login" class="btn btn-primary btn-sm">
                </div>
                <div class = "align-center reg-or-log">Dont have an account? <a href="registration.php"><span>Register</span></a></div>
            </form>
        </div>
        <?php include_once 'PhpScripts/Footer.php'?>
    </body>
</html>