<?php
    /*  Group Member(s) contribution to creating the sql scripts:
        1. Glory Iloba

        This script is responsible for updating product quantity, saving products, adding products back to the cart, and
        deleting products from the cart. Additonally it also prevents unauthorised users from proceeding to the checkout page
        to enhance security (shipping and payment details), and user experience (easily track their orders via order history which is only
        available for authenticated users, and solving orders inquiries).

        All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.
    */

    //including the database connection script. Needed to enable query execution.
    require_once 'connection.php';

    //Function for updating a product's quantity if the "update" button has been clicked    
    if(isset($_POST['update'])){
        
        /*preparing a statement that updates the quantity of a product in the cart when the "update" button has been clicked.
        This statement intakes parameters to define which product from which cart needs their quantity updated and what the quantity needs to be set as*/
        $stmt = $conn -> prepare("UPDATE cartitem SET Quantity = ? WHERE CartID = ? AND ProductID = ?");
        
        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("iii",$quantity, $_SESSION['CartID'] , $productID);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("iii",$quantity, $_SESSION['SessionCartID'] , $productID);
        }

        //retrieving data from the form (quantity and ProductID only) so that the bind functions can execute.
        $quantity = $_POST['quantity'];
        $productID = $_POST['ProductID'];

        if($stmt->execute()){
            //If the statement executes then redirect the user back to the cart page. This to review the updated product qunaity.
            header("Location: Cart.php"); 
            exit();
        } 
        
        else {
            //error handler if the query failed to execute
            echo $stmt->error;
        }

        //closing the statement to allow the next one to start
        $stmt->close();
    }

    //Function for saving a product (transfer a product from the cart to the saved products section) if the "save" button has been clicked.
    if(isset($_POST['save'])){
        /*preparing a query statement that inserts the product to the cartsaveditem table using INSERT INTO statement.
        It takes in 3 parameters to ensure that the right product from the right shopping cart gets saved. These parameters are:
        1. CartID = ID of the user's cart
        2. ProductID = ID of the product to save
        3. Quantity = the quantity of the product to save*/
        $stmt = $conn -> prepare("INSERT INTO cartsaveditem (CartID, ProductID, Quantity) VALUES (?, ?, ?)");
        
        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("iii", $_SESSION['CartID'], $productID , $quantity);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("iii", $_SESSION['SessionCartID'], $productID , $quantity);
        }

        //retrieving data from the form (quantity and ProductID only) so that the bind functions can execute.
        $quantity = $_POST['quantity'];
        $productID = $_POST['ProductID'];

        //checking if the statement is executable to detect and eliminate any errors if caught
        if($stmt->execute()){

            //closing the statement
            $stmt->close();

            /*starting a new statement to delete the product from the user's cart (stored in the cartitem table).
            This is needed to prevent duplication errors from occuring if they tried to add it back to their cart.
            
            The statement intakes 2 parameters which are:
            1. CartID: the ID of the cart to delete the product from.
            2. ProductID: the ID of the product to delete from the cart*/
            $stmt = $conn -> prepare("DELETE FROM cartitem WHERE CartID = ? AND ProductID = ?");

            /*using if and else statements to bind the cart id stored in the session variable of either users 
            (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
            if(isset($_SESSION['loggedin'])==true){
                $stmt -> bind_param("ii", $_SESSION['CartID'], $productID );
            }
            else if(isset($_SESSION['UserSession'])==true){
                $stmt -> bind_param("ii", $_SESSION['SessionCartID'], $productID );
            }

            //executing the statement
            $stmt -> execute();

            //Redirecting the user back to the Cart page. This is to review the changes made
            header("Location: Cart.php"); 
            exit(); 

            
        } else {
            //error handler if the query failed to execute
            echo $stmt->error;
            
            //closing the statement
            $stmt->close();
        }   
    }


    //Function for adding a saved product back into the cart if the "add" button has been clicked
    if(isset($_POST['add'])){
        /*preparing a query statement that inserts the product to the cartitem table using INSERT INTO statement.
        It takes in 3 parameters to ensure that the right product from the right shopping cart gets added back to the shopping cart. These parameters are:
        1. CartID = ID of the user's cart
        2. ProductID = ID of the product to add to the cart
        3. Quantity = the quantity of the product to add to the cart*/
        $stmt = $conn -> prepare("INSERT INTO cartitem (CartID, ProductID, Quantity) VALUES (?, ?, ?)");
        
        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("iii", $_SESSION['CartID'], $productID , $quantity);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("iii", $_SESSION['SessionCartID'], $productID , $quantity);
        }

        //retrieving data from the form (quantity and ProductID only) so that the bind functions can execute.
        $quantity = $_POST['quantity'];
        $productID = $_POST['ProductID'];

        //checking if the statement is executable to detect and eliminate any errors if caught
        if($stmt->execute()){

            //closing the statement
            $stmt->close();

            /*starting a new statement to delete the product from the user's saved products section (stored in the savedcartitem table).
            This is needed to prevent duplication errors from occuring if they tried to save it for later again.
            
            The statement intakes 2 parameters which are:
            1. CartID: the ID of the cart to delete the product from.
            2. ProductID: the ID of the product to delete from the cart*/
            $stmt = $conn -> prepare("DELETE FROM cartsaveditem WHERE CartID = ? AND ProductID = ?");

            /*using if and else statements to bind the cart id stored in the session variable of either users 
            (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
            if(isset($_SESSION['loggedin'])==true){
                $stmt -> bind_param("ii", $_SESSION['CartID'], $productID);
            }
            else if(isset($_SESSION['UserSession'])==true){
                $stmt -> bind_param("ii", $_SESSION['SessionCartID'], $productID);
            }

            //executing the statement
            $stmt -> execute();

            //redirecting user back to the cart page. This is needed to review the changes made.
            header("Location: Cart.php"); 
            exit(); 

            
        } else {
            //error handler if the query failed to execute
            echo $stmt->error;
            
            //closing the statement
            $stmt->close();
        } 
    }

    //Function for deleting a product from saved items list if remove button has been clicked
    if(isset($_POST['removesaveditem'])){
        /*preparing a delete statement to delete the selected product from the cartsaveditem table.
        This statement takes in 2 parameters which are:
        1. CartID: ID of the cart to delete the product from.
        2. ProductID: ID of the product to delete from the cart*/
        $stmt = $conn -> prepare("DELETE FROM cartsaveditem WHERE CartID = ? AND ProductID = ?");

        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("ii", $_SESSION['CartID'], $productID);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("ii", $_SESSION['SessionCartID'], $productID);
        }
        
        //retrieving data from the form (quantity and ProductID only) so that the bind functions can execute.
        $quantity = $_POST['quantity'];
        $productID = $_POST['ProductID'];

        //checking if the statement is executable to detect and eliminate any errors if caught
        if($stmt->execute()){
            //redirecting user back to the cart page. This is to review the changes made.
            header("Location: Cart.php"); 
            exit(); 
            
        } else {
            //error handler if the query failed to execute
            echo $stmt->error;
            
        } 
        //closing the statement to allow the next one to start
        $stmt->close();
    }

    //Function for deleting a product from the user's cart if the remove button has been clicked.
    if(isset($_POST['remove'])){
        /*preparing a delete statement to delete the selected product from the cartitem table.
        This statement takes in 2 parameters which are:
        1. CartID: ID of the cart to delete the product from.
        2. ProductID: ID of the product to delete from the cart*/
        $stmt = $conn -> prepare("DELETE FROM cartitem WHERE CartID = ? AND ProductID = ?");

        
        /*using if and else statements to bind the cart id stored in the session variable of either users 
        (authorised or unauthenticated users) to the statement to ensure the changes are made to the right shopping cart.*/
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("ii", $_SESSION['CartID'], $productID);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("ii", $_SESSION['SessionCartID'], $productID);
        }

        //retrieving data from the form (quantity and ProductID only) so that the bind functions can execute.
        $quantity = $_POST['quantity'];
        $productID = $_POST['ProductID'];

        //checking if the statement is executable to detect and eliminate any errors if caught
        if($stmt->execute()){
            //redirecting user back to the cart page. This is to review the changes made.
            header("Location: Cart.php"); 
            exit(); 
            
        } else {
            //error handler if the query failed to execute
            echo $stmt->error; 
        } 

        //closing the statement to allow the next one to start
        $stmt->close();     
    }

    //creating a script to direct authenticated user to the checkout page 
    if(isset($_POST['checkout'])){
        if(isset($_SESSION['loggedin'])==true){
            /*Preparing Select count statement to check if there are any products in their shopping cart. 
            Needed to verify if they can proceed to checkout their products. It intakes 1 parameter which
            is the registered user's cart ID to count how many products are in their cart (the products are stored in the
            cartitem table).*/
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
            if there were items/products found direct the user to the checkout page.*/
            if($itemcount > 0){
                //if there are any products present direct the user to the checkout page
                header("Location: Checkout.php"); 
                exit();
            }
            else{
                //if there are no products present in the table then inform the user via an alert message box.
                $delay = 2;
                header("Refresh: $delay");
                echo "<div class='alert alert-danger'>Add products to your cart to proceed</div>";
            }

        }
        else{
            /*if not registered send them to the login screen to restrict them from purchasing their products.

            This is done to enhance security (shipping and payment details), 
            and user experience (easily track their orders via order history which is only
            available for authenticated users, and solving orders inquiries).*/
            header("location: Login.php");
        }
    }

    //this script is used to add the details of products in the user's cart (cartitem and cartsaveditem tables) to the tables of the html page for the user (logged in or unauthenticated).
    if(isset($_SESSION['loggedin'])==true || isset($_SESSION['UserSession'])==true){

        /*query done by glory: preparing a statement that rerturn all cart items that match the user's cart id using Inner join and where clauses.
        Needed to echo the details of each product from the user's cart onto the cart item table.*/
        $stmt = $conn -> prepare("SELECT * FROM cartitem INNER JOIN product ON cartitem.ProductID = product.ProductID WHERE cartitem.CartID = ?");
        
        //binding the parameters as integers to the query for either user (logged in or unauthenticated).
        if(isset($_SESSION['loggedin'])==true){
            $stmt -> bind_param("i", $_SESSION['CartID']);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt -> bind_param("i", $_SESSION['SessionCartID']);
        }
        //executing the statement
        $stmt -> execute();
        /*getting the result then fetching all rows to MYSQLI_ASSOC (returns them as an associative array) 
        so that we can use a for loop to iterate through them an echo the details of each product to the shopping cart table*/
        $result = $stmt->get_result(); 
        $cartitems = $result->fetch_all(MYSQLI_ASSOC);
        //closing the connections
        $stmt -> close();
        $result -> close();
        
        /*query done by glory: preparing a statement that rerturn all saved cart items that match the user's cart id using Inner join and where clauses.
        Needed to echo the details of each product from the user's saved cart products onto the saved cart item table.*/
        $stmt2 = $conn -> prepare("SELECT * FROM cartsaveditem INNER JOIN product ON cartsaveditem.ProductID = product.ProductID WHERE  cartsaveditem.CartID = ?");
    
        //binding the parameters as integers to the query for either users (logged in or unauthenticated).
        if(isset($_SESSION['loggedin'])==true){
            $stmt2 -> bind_param("i", $_SESSION['CartID']);
        }
        else if(isset($_SESSION['UserSession'])==true){
            $stmt2 -> bind_param("i", $_SESSION['SessionCartID']);
        }
        
        //executing the statement
        $stmt2 -> execute();
        /*getting the result then fetching all rows to MYSQLI_ASSOC (returns them as an associative array) 
        so that we can use a for loop to iterate through them an echo the details of each product to the saved products table*/
        $result2 = $stmt2->get_result(); 
        $savedcartitems = $result2->fetch_all(MYSQLI_ASSOC);

        //closing the connections
        $stmt2 -> close();
        $result2 -> close(); 
    }
?>