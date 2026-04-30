<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23163517_Mohammed.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer=""></script>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <?php
    //starting a session. This will be needed to enable all sessions to functions on this page
    session_start();

    ?>
    <body>
        <?php
        //including the header/navigation bar to the page
        require_once 'PhpScripts/Header.php';
        //including createsession script. Used to check if unauthenticated user has a session if not creating one to identify them.
        include_once 'PhpScripts/CreateSession.php';
        //including the destroy session script to destroy the unauthenticated user's session if they've been inactive for 30 minutes.
        include_once 'PhpScripts/DestroySession.php';
        ?>

        <!--The layout was produced from scratch but some of the styling included were made by bootstrap. This is done to ease the process of
        making the design more responsive. Everything else was made from scratch -->
        <div class="background">
            <div class="row container">
                <div class="col banner-caption">
                    <h4>Welcome to TechZone</h4>
                    <p>Upgrade your lifestyle with TechZone. We offer a curated selection of high-quality tech gadgets designed to enhance your daily life. Experience the future, today.</p>
                    <button class="bannerBtn"><a href="Shop.php">Shop now</a></button>
                </div>
                <div class="col">
                    <img class = "bannerImg" src="images/banner_img.png" alt=banner_image>
                </div>
            </div>
        </div>

        <div class="container">
            <h4>New Arrivals</h4>
            <div class="row">
                <div class="col promo-caption">
                    <div class="row">
                        <div class="col caption-2-col">
                            <h6>WH-CH720N</h6>
                            <p>Wireless Noise Cancelling Headphones</p>
                            <a class="shop-now-link" href="Shop.php">Shop now</a>
                        </div>
                        <div class="col">
                            <img class = "promo-Img img2" src="images/SonyHeadphones.png" alt=promo_image>
                        </div>
                    </div>
                </div>
                <div class="col promo-caption-2">
                    <div class="row">
                        <div class="col caption-2-col">
                            <h6>DJI Mini 3</h6>
                            <p>drone</p>
                            <a class="shop-now-link" href="Shop.php">Shop now</a>
                        </div>
                        <div class="col">
                            <img class = "promo-Img" src="images/DJI.png" alt=promo_image>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-2">
                <div class="col">
                    <p>Check out the new</p>
                    <span style="font-weight: 600">NZXT Player: Two</span> 
                    <p>Pre-built PC</p>
                    <a class="shop-now-link" href="Shop.php">Shop now</a>
                </div>
                <div class="col">
                    <img class = "promo-Img-2" src="images/NZXT-pcs.png" alt=promo_image>
                </div>
            </div>
        </div>

        <?php require_once 'PhpScripts/Footer.php';?>
    </body>

</html>