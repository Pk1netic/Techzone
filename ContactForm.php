<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Form</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23145441_Yusuf.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer=""></script>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    
    <body>
        <?php
        session_start();
        //inclusing the header
        include_once 'PhpScripts/Header.php';
        //including createsession script. Used to check if unauthenticated user has a session if not creating one to identify them.
        include_once 'PhpScripts/CreateSession.php';
        //including the destroy session script to destroy the unauthenticated user's session if they've been inactive for 30 minutes.
        include_once 'PhpScripts/DestroySession.php';?>

        <!--The form was made from scratch. Only the container class/style was unoriginal aswell as the submit button as it was produced by bootstrap.
        The container was included to ease the process of making the webpage responsive.-->
        <div class="formcontainer container form">    
            <h1 class="align-center">Contact Us</h1>
            <form action = "ContactFormSuccess.php" method="post">
                <label for="Fname">First Name<span>*</span></label><br>
                <input id="Fname" type="text" required="" name="Fname" pattern="[a-zA-Z\s]+" title="Enter characters only" class="input-box">
         
                <label for="Lname">Last Name<span>*</span></label><br>
                <input id="Lname" type="text" required="" name="Lname" pattern="[a-zA-Z\s]+" title="Enter characters only" class="input-box">
                
                <?php
                //If the user isn't logged in then display the email input box.
                //This is because we already authorised user's email address and also so that we have a way of contacting the unauthorised user.
                    if(isset($_SESSION['loggedin']) != true){
                        echo '<label for="Email address">Email Address<span>*</span></label><br>
                        <input id="Email_Address" type="email" required="" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="enter a valid email address" name="email" class="input-box">';
                    }
                ?>
                <label for="Reasoning">Reasoning<span>*</span></label><br>
                <select required="" name="reasoning">
                    <option value="" disabled selected>Select</option>
                    <option value='Return Order'>Return Order</option>
                    <option value='About Order'>About Order</option> 
                    <option value='Other'>Other</option>  
                </select>
                
                <label for="Message_box">Message<span>*</span></label><br>
                <textarea class="input-box" id="message" required="" name="message" maxlength="500" rows="5"></textarea> 
                
                <div class="align-center">
                    <input type ="submit" name="submit" value="Submit" class="btn btn-primary btn-sm">
                </div>
            </form>
        </div>
        <?php include_once 'PhpScripts/Footer.php';?>
    </body>
</html>