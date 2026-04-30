<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
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
        //including the php script for this page
        include_once 'PhpScripts/ShopScript.php';   
       
        ?>

        <h4 class="AlignTitle container">Products</h4>
        <!--creating the product filter card. I took reference from "https://www.youtube.com/watch?v=j3vK2I5LoBw&t=377s". 
        However I have changed the colour of it, way of filtering and listing the products, aswell as the queries.-->
        <div class="align-shop container">
            <form class="col-md-3" action="" method="GET">
                <div class="card-heading">
                    <h5>Filter
                        <button type ="submit" class="btn btn-primary">Filter</button>
                    </h5>
                </div>
                <div class="card-body">
                    <h6>Categories</h6>
                    <hr>
                    <?php
                    /*including ProductFilterCard.php which is used to echo all categories in the product table to the filter card.
                     Aswell as storing the checked categories post submittion to an array so that it can be used to only view the products
                     from the checked categories onto the screen.*/
                    require_once 'PhpScripts/ProductFilterCard.php';
                    ?>
                </div>
            </form> 

            <!-- Creating the main section (Product cards). It's all made from scratch except some of the styling came from bootstrap css file-->
            <main class="col">
                <?php
                //Including the script responsible for viewing all products or the filtered products onto the screen if selected.
                include_once 'PhpScripts/FilterProductsScript.php';
                
                //while the next row (record) is present in product table fetch the current row's enteries onto the product card
                while($row = $products->fetch_assoc()){
                ?>
                <div class = "card">
                    <!--echoing the image directory retrieved from the database (e.g. Images/product.png) into that image source -->
                    <div class="image"><img src="<?php echo $row["Image"];?>" alt=productImg></div>
                    <div class="caption">
                        <!--echoing the product name-->
                        <span><?php echo $row["Name"];?></span>
                        <br>
                        <!--echoing the price of the product-->
                        <span style="font-weight:bold;">price: £<?php echo $row["Price"];?></span>
                        <br>
                        <!--echoing the product rating-->
                        <span>rating: <?php echo number_format($row['Rating'], 1);?>/5</span>
                        <form action="" method="GET"> <!--start of form-->
                            <div>
                                <label>Quantity:</label>
                                <!--reqursively printing the ratings into the select list-->
                                <select class = "dropDown" name="quantity" id="count">
                                    <?php
                                    $quantities = array("1","2","3","4","5");
                                    foreach($quantities as $rowquantity){
                                        echo "<option value='$rowquantity'>$rowquantity</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type = "submit" id='button' name="addcart" value= "addcart" class = "AddBtn">Add to cart</button>
                            <!--Creating hiddden inputs for the product rating, product id, and product name so that i can retrieve and use them in the script-->
                            <input type=hidden name=rating value='<?php echo $row['Rating'];?>'>
                            <input type=hidden name=ProductID value='<?php echo $row["ProductID"];?>'>
                            <input type=hidden name=prodname value='<?php echo $row["Name"];?>'>
                            <div>
                                <label>Rate:</label>
                                <!--reqursively printing the quantities into the select list-->
                                <select class = "dropDown" name="rating" id="count">
                                    <?php
                                    $ratings = array("1","2","3","4","5");
                                    foreach($ratings as $rating){
                                        echo "<option value='$rating'>$rating</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button name = "submitreview" type="submit" class = "SubmitBtn">Submit</button>
                        </form> <!--end of form-->
                    </div><!-- end of caption -->
                </div><!-- end of card -->
                <?php
                }#end of while loop
                ?>
            </main>
        </div> <!--end of container-->
        <?php include_once 'PhpScripts/Footer.php'?>
    </body>
</html>