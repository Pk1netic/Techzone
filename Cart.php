<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer=""></script>
    </head>
    <body>
        <?php
        //starting a session to enable sessions for this page.
        session_start();

        //including the header to the webpage (navigation bar).
        require_once 'PhpScripts/Header.php'; 
        //including createsession script. Used to check if unauthenticated user has a session if not creating one to identify them.
        include_once 'PhpScripts/CreateSession.php';
        //including the destroy session script to destroy the unauthenticated user's session if they've been inactive for 30 minutes.
        include_once 'PhpScripts/DestroySession.php';
        
        //including the php script for this html file (CartScript.php).
        include_once 'PhpScripts/CartScript.php';?>

        <div class="container">
            <h4 class="AlignTitle">Shopping Cart</h4>
            <!--creating a table to store the product items-->
            <table class=".thead-light">
                <tr class = "headings">
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Remove</th>
                    <th>Save Product</th>      
                </tr>
                <?php
                $total = 0; #initializing a variable to store the total price of all products combined in the cart

                //if the size of cartitems is greater than 0 (if products are present) then execute the foreach loop which echos the details of each product to the table.
                if($cartitems > 0){
                    //echoing details of all products in the cart to the table
                    foreach($cartitems as $itemRow){       
                        //creating a variable to store the total price;
                        $totalprice = $itemRow['Price'] *$itemRow['Quantity'];
                        ?>
               
                    <!--Adding a form in the for loop to uniquely identify each product.
                    Needed to ensure the changes are only made to the product (updating quantity, deleting it etc.)-->
                    <Form action="Cart.php" method = "POST">
                        <tr>
                            <td>
                            <img class = "product-image" src="<?php echo $itemRow['Image'] ?>" alt=Product>
                            </td>
                            <td><?php echo $itemRow['Name'] ?></td>
                            <td><?php echo '£'.$itemRow['Price'] ?></td>
                            <td class="Align-items">
                                <!--select box used to create-->
                                <select class = "dropDown" name="quantity" id="quantity">
                                    <?php
                                    $quantities = array("1","2","3","4","5");
                                    foreach($quantities as $quantity){
                                        $selected = ($quantity == $itemRow['Quantity']) ? 'selected' : ''; 
                                        echo "<option value='$quantity' $selected>$quantity</option>"; 
                                    }
                                    ?>
                                </select>
                                <!--created an hidden input box this is so that we can retrieve the Id of the product-->
                                <input type="hidden" name="ProductID" value="<?php echo $itemRow['ProductID']; ?>"> 
                                <br>
                                <!--Button used to update quantity-->
                                <button type="submit" name="update" class="Addbtn save-remove-btn">update</button>
                            </td>
                            <td><?php echo '£'.$totalprice; ?></td>
                            <td><button type="submit" name="remove" class="removebtn"><i class="fa-solid fa-trash-can fa-xl"></i></td></button>
                            <td><button type="submit" name="save" class="Addbtn save-remove-btn">save</button></td>   
                        </tr>
                    </Form> 
                <?php
                $total+=$totalprice; #increasing the total (price of all products combined)
                } //end of while loop
                } //End of if statement   
                ?>
            </table>
            <br>

            <!--echoing the overall price -->
            <p class="price-align">Total: £<?php echo number_format($total, 2); ?><p>
            
            <!--Button that directs user to checkout page-->
            <form class="centerBtn" method = "POST">
                <button type="submit" name="checkout" class="btn btn-primary checkoutbtn">Checkout</button>
            </form>

            <!--Creating saved products section-->
            <?php  
            if($savedcartitems > 0){ ?>
                <h4 class="AlignTitle">Saved Products</h4>     
                    <table class=".thead-light">
                        <tr class = "headings">
                            <th>Product</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                            <th>Add to cart</th>      
                        </tr>
            <?php 
            //echoing details of all saved products to the table
            foreach($savedcartitems as $itemRow){       
                $totalprice = $itemRow['Price'] *$itemRow['Quantity'];
            ?>
                <!--Adding a form in the for loop to uniquely identify each product.
                Needed to ensure the changes are only made to the  product (adding it back to cart, deleting it etc.)-->
                <Form action="Cart.php" method = "POST">
                    <tr>
                        <td>
                        <img class = "product-image" src="<?php echo $itemRow['Image'] ?>" alt=Product>
                        </td>
                        <td><?php echo $itemRow['Name'] ?></td>
                        <td><?php echo '£'.$itemRow['Price'] ?></td>
                        <td class="Align-items">
                            <select class = "dropDown" name="quantity" id="quantity">
                                <?php
                                $quantities = array("1","2","3","4","5");
                                foreach($quantities as $quantity){
                                    $selected = ($quantity == $itemRow['Quantity']) ? 'selected' : ''; 
                                    echo "<option value='$quantity' $selected>$quantity</option>"; 
                                }
                                ?>
                            </select>
                            <!--created an hidden input box for the product ID this is so that we can retrieve the Id of the product in our script-->
                            <input type="hidden" name="ProductID" value="<?php echo $itemRow['ProductID']; ?>"> 
                        </td>
                        <td>£<?php echo $totalprice ?></td>
                        <td><button type="submit" name="removesaveditem" class="removebtn"><i class="fa-solid fa-trash-can fa-xl"></i></td></button>
                        <td><button type="submit" name="add" class="Addbtn save-remove-btn">add</button></td>     
                    </tr>
                </Form>
                <?php
                    } //end of for loop
                }//end of if statement
            ?>
            </table>
        </div>  
        <!-- Appending the footer -->
        <?php require_once 'PhpScripts/Footer.php' ?>
    </body>
</html>