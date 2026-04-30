<?php 
    /*
    Team Members contribution to this script:
    1. Glory Iloba
    2. Yusuf Jawad
    3. Mohammed Soma
    4. Ubayd Alam

    The purpose of this script is to create a cart and sessionID for unauthorised users. This is needed to allow the products to be stored in their shopping cart.
    this script will be implemented in all pages they're not restricted from to ensure that they get provided a Unique session ID and cart.
    
    All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.*/

    
    //including the database connection php file to connect the queries to the database and enable their execution.
    include_once 'connection.php';

    if(isset($_SESSION['loggedin'])!== true){

        //checking if variable SessionID isn't present or is set to false if so generate a unique ID for the user and add it to the cart table.
        if(!isset($_SESSION['UserSession'])){
            /*All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.*/

            //generating a uniqid for the user using unidid() function
            $SessionID = uniqid();
            
            //preparing an insert statement to insert the sessionID to the cart table. This is needed to create a cart for the user
            $stmt = $conn -> prepare("INSERT INTO cart (SessionID) VALUES (?)");

            //binding the statement parameters with the user's sessionID as string because the sessionID is a string.
            $stmt -> bind_param('s',$SessionID);

            //executing the statement
            $stmt -> execute();

            //closing the statement to allow the next one to start
            $stmt -> close();

            //preparing a select statement to get the cartID of the user using their sessionID. This is needed to minimise the process of retrieving it within our scripts as it will be used alot.
            $getCart = $conn -> prepare("SELECT CartID FROM cart WHERE SessionID = ?");

            //binding the statement parameters with the user's sessionID as string because the sessionID is a string.
            $getCart -> bind_param("s",$SessionID);  
            
            //checking if query can execute to prevent errors and retrieval of a null value.
            if ($getCart -> execute()){

                //if executed bind the result to a new variable called $cartID
                $getCart -> bind_result($cartID);

                //fetching the result to the cartID variable so that it can store the user's cart ID.
                $getCart -> fetch(); 
                
                //creating session variables for the user
                $_SESSION['SessionCartID'] = $cartID;
                $_SESSION['UserSession'] = true; #will be used to check if they got a session ID and not create a new one
                $_SESSION['SessionID'] = $SessionID; #storing the session ID as a Session global variable called "SessionID". Needed to identify them.
                
                //closing the statement and connection to prevent attackers from accessing content of our database
                $getCart ->close();
                $conn ->close();
            }
            else{
                //if it fails to execute echo an error to notify the user
                echo "Error Caught:".$conn->$error;

                //closing the statement and connection to prevent attackers from accessing content of our database
                $getCart ->close();
                $conn ->close();
            }            
        }
    }
    
?>