<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order placed sucessfully</title>
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
        //including CheckoutScript.php
        include_once 'PhpScripts/CheckoutMessageScript.php';
        ?>

        <!--The layout was taken from bootstrap some of the styling attributes were also included but took no contribution to the styling of the page-->
        <div class='card container .col message-design'>
            <div class="card no-border">
                <div class="card-body">            
                    <h4 class=".card-title">Your Order has been Placed</h4>
                    <!--printing out the customer's order details. The orderdetails variable has been retained from the CheckoutScript.php file-->
                    <p><?php foreach($orderdetails as $orderRow){ ;?>
                        Thank you <?php echo $orderRow['First_Name']." ". $orderRow['Last_Name'];?> for shopping with TechZone, your order payment of £<?php echo $orderRow['TotalPrice'] ;?> has been taken. 
                       Details of your order will be sent to <?php echo $orderRow['Email_Address'] ;?> along side its tracking details soon. <?php } ;?>
                    <p>
                </div>
            </div>
            <div class="card text-center no-border">
                <div class="card-body">
                    <img class = "checkmark-image" src="images/red check.png" alt=checkmark>
                </div>
            </div>
            <div class="card text-end no-border">
                <div class="card-body card-btn">
                <a href="index.php"><button class='home-btn'>Go Home</button></a>
                </div>
            </div>
        </div>
        <?php require_once 'PhpScripts/Footer.php' ?>
    </body>
</html>