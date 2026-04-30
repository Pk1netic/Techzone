<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registeration Form</title>
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
        //including createsession script to create a session for the user if they're not logged in.
        include_once 'PhpScripts/CreateSession.php';
        //including destroy session script which destroys the unauthenticated user's session if their time limit has passed (30 minutes);
        include_once 'PhpScripts/DestroySession.php';
        //including the script for this web page.
        include_once 'PhpScripts/RegistrationScript.php';

        ?>
        
        <!--The form was made from scratch. Only the container class/style was unoriginal aswell as the submit button as it was produced by bootstrap.
        The container was included to ease the process of making the webpage responsive. The form contains pattern constraints to ensure that the data captured is accurate-->
        <div class="formcontainer container form">
            <h1 class="align-center">Register</h1>
            <form action = "registration.php" method="post">
                <label for="fname">First name<span>*</span></label><br>
                <input id="firstname" type="text" name="firstname" pattern="[a-zA-Z\s]+" title="Enter characters only" required="" class="input-box">
                
                <label for="lname">Last name<span>*</span></label><br>
                <input id="lastname" type="text" name="lastname" pattern="[a-zA-Z\s]+" title="Enter characters only" required="" class="input-box">
                
                <label for="phoneNo">Phone number</label><br>
                <input id="phonenumber" type ="tel" name = "phonenumber" pattern="[0-9]+" maxlenght="15" title="Enter numbers only" placeholder="Optional" class="input-box">
                
                <label for="email">Email<span>*</span></label><br>
                <input id="email" type="email" name="email" maxlenght="320" required="" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="enter a valid email address" class="input-box">
                
                <label for="password">Password<span>*</span></label><br>
                <input id="password" type="password" name="password" required="" class="input-box">
                
                <div class="align-center" >
                    <input type ="submit" name="registration" value="Register" class="btn btn-primary btn-sm">
                </div>
                <div class ="align-center reg-or-log">Already have an account? <a href="Login.php"><span>Login</span></a></div>
            </form>
        </div><!-- content container -->
        <!--appending the footer-->
        <?php include_once 'PhpScripts/Footer.php'?>    
    </body>
</html>