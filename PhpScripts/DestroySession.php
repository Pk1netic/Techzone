<?php
/*
Team Members contribution to this script:
1. Glory Iloba
2. Yusuf Jawad
3. Mohammed Soma
4. Ubayd Alam

This script destroys an unauthorised user's session when they have been inactive for longer than 30 minutes or they've logged 
into their account. We took this approach to destroy their shopping cart stored in our database to save up storage and security purposes.

All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.*/

//including the database connection php file to connect the queries to the database and enable their execution.
include_once 'connection.php'; 

//checking if the user isn't logged in or loggedin session variable isn't set
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
    
    //checking if the user has been inactive for longer than 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        //All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.

        /*Preparing a statement that deletes all products from the cart (stored in cartitem table). 
        This needs to be done to save storage in the cartitem table and to be able to remove the sessionID stored in the cart table.*/
        $stmt = $conn->prepare("DELETE FROM cartitem WHERE CartID = ?");
        
        //binding the statement with the session cartID of the user.
        $stmt->bind_param("i", $_SESSION['SessionCartID']);
        
        //executing the statement
        $stmt->execute();

        //closing the statement to enable the next query to execute
        $stmt->close();

        /*Deleting all saved products (stored in cartsaveditem table) from the user's session shopping cart. 
        This needs to be done for the same reason as removing the products from their cart.
        */
        $stmt = $conn->prepare("DELETE FROM cartsaveditem WHERE CartID = ?");

        //binding the statement with the session cartID of the user as an integer.
        $stmt->bind_param("i", $_SESSION['SessionCartID']);
        
        //executing the query
        $stmt->execute();

        //closing the statement to enable to the next query to execute
        $stmt->close();

        //preparing a statement that deletes the user's session cart from the cart table to officially remove their session shopping cart.
        $stmt = $conn -> prepare("DELETE FROM cart WHERE SessionID = ? ");
        
        //binding the statement parameters with the user's sessionID as string because the sessionID is a string.
        $stmt -> bind_param('s',$_SESSION['SessionID']);
        
        //executing the statement
        $stmt -> execute();

        //closing the statement
        $stmt -> close();

        //unsetting the session then destroying it
        session_unset(); 
        session_destroy();

        //refresh the page and direct them to the Index/home page;
        $delay =2;
        header("Refresh: $delay url =index.php");
    } 
    else {
        //if they haven't been inactive for longer than 30 minutes then set last_activity to the current time stamp (needed to basically reset the timer).
        $_SESSION['last_activity'] = time();
    }
}

//checking if the user is logged in, and SessionCartID is also set so that we can remove their sessionID/cart from the cart table
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_SESSION['SessionCartID'])) {
    /*All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.*/

    /*Preparing a statement that deletes all products from the cart (stored in cartitem table). 
    This needs to be done to save storage in the cartitem table and to be able to remove the sessionID stored in the cart table.*/
    $stmt = $conn->prepare("DELETE FROM cartitem WHERE CartID = ?");
    
    //binding the statement with the session cartID of the user.
    $stmt->bind_param("i", $_SESSION['SessionCartID']);
    
    //executing the statement
    $stmt->execute();

    //closing the statement to enable the next query to execute
    $stmt->close();

    /*Deleting all saved products (stored in cartsaveditem table) from the user's session shopping cart. 
    This needs to be done for the same reason as removing the products from their cart.
    */
    $stmt = $conn->prepare("DELETE FROM cartsaveditem WHERE CartID = ?");

    //binding the statement with the session cartID of the user as an integer.
    $stmt->bind_param("i", $_SESSION['SessionCartID']);
    
    //executing the query
    $stmt->execute();

    //closing the statement to enable to the next query to execute
    $stmt->close();

    //preparing a statement that deletes the user's session cart from the cart table to officially remove their session shopping cart.
    $stmt = $conn -> prepare("DELETE FROM cart WHERE SessionID = ? ");
    
    //binding the statement parameters with the user's sessionID as string tbecause he sessionID is a string.
    $stmt -> bind_param('s',$_SESSION['SessionID']);
    
    //executing the statement
    $stmt -> execute();

    //closing the statement
    $stmt -> close();
}
?>