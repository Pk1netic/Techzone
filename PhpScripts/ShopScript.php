<!--PHP script to add selected quantity of the product to cart table
It was all created from scratch by Glory.-->
<?php

    //including connection.php script to enable the queries to connect to the database and execute.
    require_once 'connection.php';

    //script for adding a product to the cart for either users (authorised and unauthorised) when the add to cart button has been clicked
    if(isset($_GET['addcart'])){  
        
        /*returning quantity and product id from the form (they will be used to add the product to their cart).*/
        $quantity = $_GET["quantity"];
        $ProductID = $_GET["ProductID"];

        /*Query produced by Glory: preparing a select count statement to check if the product is in the user's shopping cart (stored in cartitem table).
        this is needed to verify whether the products can be added to their cart or not. if the count is higher than 0 then it shouldn't be added to prevent
        duplication errors. The statement takes in 2 arguements to ensure accurate retrieval of the product in the user's cart which are:
        1. CartID: the ID of the shopping cart that belongs to the user.
        2. ProductID: the ID of the product they want to add to their shopping cart*/
        $prodCount = $conn->prepare("SELECT COUNT(ProductID) FROM cartitem WHERE CartID = ? AND ProductID = ?");

        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure that we're counting from the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $prodCount -> bind_param("ii", $_SESSION['CartID'], $ProductID);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $prodCount -> bind_param("ii", $_SESSION['SessionCartID'], $ProductID);
        }

        $prodCount -> execute(); #executing the statement
        $prodCount->bind_result($isPresent); #binding the result to a variable names "isPresent"
        $prodCount->fetch(); #fetching the result to the variable

        //if the product count is greater than 0 (the product is present in the cart) then execute the if statement.
        if($isPresent > 0){
            /*if found in cartitem table echo an error message to inform the user that it's already in their cart then
            delay refresh to the shop page. This ensures that they have enough time to read the message.
            The alert was taken from https://getbootstrap.com/docs/4.0/components/alerts/*/
            $delay =2;
            header("Refresh: $delay url =Shop.php");
            echo "<div id='alert' class='alert alert-danger'>Product is already present in the cart</div>";

            //closing the statement to allow the next one to execute and connect to the database.
            $prodCount->close();  
        }
        //if the product count isn't greater than 0 then execute the else statement.
        else{
            //closing the previous statement to allow the next one to execute.
            $prodCount->close(); 

            /*Query produced by Glory: preparing a select count statement to check if the product is in the user's cart saved products section (stored in cartsaveditem table).
            this is needed to verify whether the product can be added to their cart. if the count is higher than 0 then it shouldn't be added to prevent
            duplication errors if they was to save it for later. The statement takes in 2 arguements to ensure accurate retrieval of products in the user's cart which are:
            1. CartID: the ID of the shopping cart that belongs to the user.
            2. ProductID: the ID of the product they want to add to their shopping cart*/
            $prodCount = $conn->prepare("SELECT COUNT(ProductID) FROM cartsaveditem WHERE CartID = ? AND ProductID = ?");

            /*using if and else statements to bind the cart id stored in the session variable of either users 
            (authorised or unauthenticated users) to the statement to ensure that we're counting from the right shopping cart.*/
            if(isset($_SESSION['loggedin'])==true){
                $prodCount -> bind_param("ii", $_SESSION['CartID'], $ProductID);
            }
            else if(isset($_SESSION['UserSession'])==true){
                $prodCount -> bind_param("ii", $_SESSION['SessionCartID'], $ProductID);
            }
            $prodCount -> execute(); #executing the statement
            $prodCount->bind_result($isPresent); #binding the result to a variable name "isPresent" will be used to verify if the product can be added to the cart or not.
            $prodCount->fetch(); #fetching the result to the isPresent variable.
            
            //if the product count is greater than 0 (the product is present in the cart) then execute the if statement.
            if($isPresent > 0){
                 /*if found in cartitem table echo an error message to inform the user that it's already in their cart then
                delay refresh to the shop page. This ensures that they have enough time to read the message.
                The alert was taken from https://getbootstrap.com/docs/4.0/components/alerts/*/
                $delay =2;
                header("Refresh: $delay url =Shop.php");
                echo "<div id='alert' class='alert alert-danger'>The product is already present in the cart. Check your saved list</div>";
                
                //closing the statement to allow the next one to execute and connect to the database.
                $prodCount->close();  
            }
            //if the product count isn't greater than 0 then execute the else statement which is to add the product to their cart.
            else{
                //closing previous statement to allow the next one to connect to the database.
                $prodCount->close(); 
                
                /*Query done by Glory: Preparing an insert into statement that inserts the product details to the user's cart (cartitem table).
                The statement takes in 3 arguements to ensure that the right amount of the product gets added to their shopping cart which are:
                1. CartID: ID of the user's cart to add the product to
                2. ProductID: the ID of the product to add to their cart
                3. Quantity: the quantity of the product to add to their cart*/
                $getCartResult = $conn->prepare("INSERT INTO cartitem (CartID, ProductID, Quantity) VALUES (?,?,?)");

                /*using if and else statements to bind the cart id stored in the session variable of either users 
                (authorised or unauthenticated users) to the statement to ensure that the product gets added to the right shopping cart.*/
                if(isset($_SESSION['loggedin'])==true){
                    $getCartResult -> bind_param("iii", $_SESSION['CartID'], $ProductID,$quantity);
                }
                else if(isset($_SESSION['UserSession'])==true){
                    $getCartResult -> bind_param("iii", $_SESSION['SessionCartID'], $ProductID,$quantity);
                }

                //if the statement executes then execute the if statement.
                if($getCartResult->execute()){
                     /*echo an success message to inform the user that it has been added to their cart then
                    delay a refresh to the shop page. This ensures that they have enough time to read the message.
                    The alert was taken from https://getbootstrap.com/docs/4.0/components/alerts/*/
                    $delay =2;
                    header("Refresh: $delay url=Shop.php");
                    $prodName = $_GET["prodname"]; //returning the product name from the form. Will be used to inform them what product has been added.
                    print "<div class= 'alert alert-success'>'".$prodName."' has been added to your cart.</div>";
                    
                    //closing the statement
                    $getCartResult ->close();
                }
                //if the statement failed to execute then execute the else statement.
                else{
                    // echo an error message
                    echo $conn->$error;

                    //closing the statement
                    $getCartResult ->close();
                }
            }
        }
    }
    
    //script for submitting a product rating once the submit button has been clicked. It should only work for authorised users as it's only restricted to them.
    if(isset($_GET["submitreview"])){
        //if the user is logged in then execute the else statement (update the rating of the product).
        if(isset($_SESSION["loggedin"])==true){
            /*Statement produced by Glory: Preparing a statement to return the rating from the product. This needs to be done so that we can use it to calculate the new mean
            of the rating*/
            $stmt = $conn -> prepare("SELECT Rating FROM product WHERE ProductID = ?");
            $stmt -> bind_param('i',$ProductID); #binding the ID of the product to the statement

            //getting the product ID
            $ProductID = $_GET['ProductID'];

            $stmt -> execute(); #executing the statement
            $stmt ->bind_result($ratingsum); #binding the result to a new variable called ratingsum
            $stmt ->fetch(); #fetching the result to the variable
            $stmt ->close(); #closing the statement to allow the next one to start

            //getting the rating from the form and storing it to a variable called userRating
            $userRating = $_GET['rating'];

            //calculating the mean to return the new average rating of the product
            $newRating = ($userRating+$ratingsum)/2;

            /*Statement produced by Glory: Preparing an update statement to set the rating of the product to the new rating produced.
            This ensures that it can be viewed on the product's card.*/
            $stmt = $conn -> prepare("UPDATE product SET Rating = ? WHERE ProductID = ?");
            $stmt -> bind_param('di',$newRating,$ProductID); #binding the rating as a double since it's a double, and Product ID as an integer
            $stmt -> execute(); #executing the statement
            $stmt -> close(); #closing the statement
        }
        //if the user isn't logged in then execute the else statement
        else{
            //restrict customer from rating the product since it's a service not provided for them.
            //output an message indicating this to inform them.
            //The alert design was taken from https://getbootstrap.com/docs/4.0/components/alerts/
            $delay =2;
            header("Refresh: $delay url =Shop.php");
            echo "<div class='alert alert-danger'>Login to access this feature.</div>";
            
        }
    }
    
?>