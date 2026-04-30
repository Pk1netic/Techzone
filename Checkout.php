<!DOCTYPE html>
<html>
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout products</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <?php
    //starting a session to enable sessions to be including in this page.
    session_start();

    //including database connection script to connect and execute the statements.
    include_once 'PhpScripts/connection.php';
    if(isset($_SESSION['loggedin']) == true){
        /*Statement produced by Glory: Preparing Select count statement to check if there are any products in their shopping cart. 
        This is implemented on this page to prevent access to it via URL if trying to bypass the restriction to this page
        when there are no products present in the user's shopping cart.*/
        $sql = $conn -> prepare("SELECT COUNT(*) FROM cartitem WHERE CartID = ?");

        //binding the statement with the user's cart ID as an integer
        $sql -> bind_param('i',$_SESSION['CartID']);

        //executing the statement
        $sql -> execute();

        //bind the result to a new variable called $itemcount
        $sql -> bind_result($itemcount);

        //fetching the result then closing the statement
        $sql -> fetch();
        $sql -> close();

        /*Using the itemcount variable to check if there are any products present in their cart.
        if there were items/products found enable access to this page else direct them to the index/home page.*/
        if(!$itemcount > 0){
            //if there are no products present direct the user to the Idex/home page
            header("Location: index.php"); 
            exit();
        }
    }else{
        //if they aren't logged in direct them to the home page
        header("Location: Index.php");
    }
    ?>

    <body>
        <?php 
        //including the header (navigation bar) to the webpage.
        require_once 'PhpScripts/Header.php';
        ///including createsession script. Used to check if unauthenticated user has a session if not creating one to identify them.
        include_once 'PhpScripts/CreateSession.php';
        //including the destroy session script to destroy the unauthenticated user's session if they've been inactive for 30 minutes.
        include_once 'PhpScripts/DestroySession.php';?>

        <!--The form was made from scratch. Only the container class/style was unoriginal aswell as the submit button as it was produced by bootstrap.
        The container was included to ease the process of making the webpage responsive.-->
        <div class="formcontainer container form checkoutform">
            <h3>Checkout</h3>
            <h4>Shipping Information</h4>
            <form class ="form" action = "Checkoutsuccess.php" method="POST">
                <!--This section covers the shipping information to be stored to the shippingaddress table of our database. 
                It contains pattern constraints to ensure that the data captured is accurate-->
                <label for="HouseNum">House number<span style="color:#EF3737">*</span></label><br>
                <input id="HouseNum" type="number" name="HouseNum" required="" class="input-box">
                
                <label for="Street/road">Street/road<span style="color:#EF3737">*</span></label><br>
                <input id="str/rd" type="text" name="str/rd" required="" pattern="[a-zA-Z\s]+" maxlength="85" title="Input a valid street name" class="input-box">
                
                <label for="Postcode">Postcode<span style="color:#EF3737">*</span></label><br>
                <input id="Postocde" type = "text" name = "Postcode" required="" maxlength="10" class="input-box">
                
                <label for="County">County</label><br>
                <input id="County" type="text" name="County" placeholder="Optional" pattern="[a-zA-Z\s]+" maxlength="100" class="input-box">
                
                <label for="Town/City">Town/City<span style="color:#EF3737">*</span></label><br>
                <input id="twn/city" type="text" name="town/city" pattern="[a-zA-Z\s]+" maxlength="100" required="" class="input-box">
                
            

                <h4>Payment Information</h4>
                <!--This section covers the payment information to be stored to the payment table of our database. 
                It contains pattern constraints to ensure that the data captured is accurate-->
                <label for="Card Number">Card Number<span style="color:#EF3737">*</span></label><br>
                <input id="Cardnum" type="text" name="cardNum"  pattern="[0-9]{16,19}" required="" placeholder="e.g 2938928372837282" title="Cardnumber needs to be atleast 16 or 19 digits long"class="input-box">
                
                <label for="expiryDate">Expiry date<span style="color:#EF3737">*</span></label><br>
                <input id="expDate" type="text" name="expDate" required="" placeholder="MM/YY" pattern="\d{2}/\d{2}" title="Pattern needs to be MM/YY e.g 01/24" class="input-box">
                
                <label for="Postcode">Cardholder name<span style="color:#EF3737">*</span></label><br>
                <input id="cardHName" type = "text" name = "cardHName" required="" pattern="[a-zA-Z\s]+" title="the name can only contain characters e.g. John Silver" class="input-box">
                
                <label for="CVC">CVC<span style="color:#EF3737">*</span></label><br>
                <input id="CVC" type="text" name="CVC" required=""  pattern="^\d{3}$" title="number have to be 3 digits long (e.g 123)" class="input-box">
                
                <div class="align-center" >
                    <input type ="submit" name="checkout" class="btn btn-primary btn-sm">
                </div>
            </div>
            <!--Including the footer to the webpage -->
            <?php require_once 'PhpScripts/Footer.php'?>
        </form>
    </body>
</html>