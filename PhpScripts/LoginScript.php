<?php 
    /*Group members contribution to sql script:
    1. Glory Iloba

    This script is responsible for enabling the user to log into an account if authorised once the login button has been clicked.
    Also all queries in this script uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.*/    
    
    if (isset($_POST["login"])) {
        // Connecting to the database
        require_once 'PhpScripts/connection.php';

        /*Statement produced by Glory: Preparing a select statement to return the user ID, password, first name, and last name from
        the user table where the email address meets the one submitted via the form. This is needed to check if
        the account exists.*/
        $stmt = $conn->prepare(
            "SELECT UserID, password, First_Name, Last_Name FROM user WHERE Email_Address = ?"
        );

        //Binging the prepared query statement with its parameter (email address)
        $stmt->bind_param("s", $Email_Address);

        //Getting the email address and password posted from the form
        $Email_Address = $_POST["email"];
        $password = $_POST["password"];

        // Executing the sql query and storing it (it will be used to check if the user account is present)
        $stmt->execute();
        $stmt->store_result();

        // Check if the user account exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($UserID, $hashed_password, $First_Name, $Last_Name);

            // Fetching the result to the variables
            $stmt->fetch();

            // Verify the hashed password to the password submitted. If the same password then the if statement will execute.
            if (password_verify($password, $hashed_password)) {
                // Creating variables for the session.
                $_SESSION["loggedin"] = true; #will be used to check if they are logged in 
                $_SESSION["UserID"] = $UserID; #will be used to define the user in sql scripts
                $_SESSION["First_Name"] = $First_Name; #will be used to define their first name in the navigation bar
                $_SESSION["Last_Name"] = $Last_Name; #will be used to define their last name in the navigation bar
                $_SESSION["Email_Address"] = $Email_Address; #will be used for the contact form

                /*query done by glory: selecting all columns from cart table that contains a UserID that matches it, 
                It will be used to check if they don't got a cart if they do one will be created for them.*/
                $query = $conn -> prepare("SELECT COUNT(*) FROM cart WHERE UserID = ?");

                $query -> bind_param('i',$UserID); #binding the statement with the user's ID
                $query -> execute(); # executing the statement
                $query -> bind_result($cartSize); #binding the result to a new variable call cartSize
                $query -> fetch(); #fetching the result to the cartSize variable
                $query -> close(); #closing the query statement
                
                //If the cartsize is equal to 0 a cart will be created for the user
                if($cartSize == 0){

                    /*query done by glory: Preparing an insert into statement to automatically create
                    a shopping cart for the customer by inserting the user's ID to the cart table.*/
                    $sql = $conn -> prepare("INSERT INTO cart (UserID) VALUES (?)");

                    $sql -> bind_param('i',$UserID);#binding the user ID to the statement
                    $sql -> execute(); #executing the statement
                    $sql -> close(); #closing the statement to start the next one.

                    /*query done by glory: Preparing select statement to return the cart Id of the user
                    so that we can store it in a session variable.*/
                    $stmt = $conn -> prepare("SELECT CartID FROM cart WHERE UserID =?");

                    $stmt -> bind_param('i',$UserID); #binding the user ID to the statement
                    $stmt -> execute(); # executing the statement
                    $stmt -> bind_result($cartSize); # binding the result to a new variable named cartSize
                    $stmt -> fetch(); # fetching the result to the variable
                    $_SESSION["CartID"] = $cartSize; # store the result to a new session variable called "CartID"
                    $stmt -> close(); # closing the statement

                    /*setting their user session (session provided if unauthorised) to false to prevent errors of dictecting the
                    type of user they are (logged in or not logged out) and to also allow them to access all services.*/
                    $_SESSION['UserSession'] = false;
                }
                //if there's already a cart present for the user then store its id to the cartID session variable
                else if ($cartSize > 0){
                    //query done by Glory: Preparing a select statement to store the cart id of the user to a session variable.
                    $stmt = $conn -> prepare("SELECT CartID FROM cart WHERE UserID =?");
                    $stmt -> bind_param('i',$UserID); #binding the user ID to the statement
                    $stmt -> execute(); # executing the statement
                    $stmt -> bind_result($cartID); # storing the result to a variable named cartID
                    $stmt -> fetch(); # fetching the result to the variable
                    $_SESSION["CartID"] = $cartID; # storing the variable to a session variable called CartID
                    $stmt -> close(); #closing the statement

                    /*setting their user session (session provided if unauthorised) to false to prevent errors of dictecting the
                    type of user they are (logged in or not logged out) and to also allow them to access all services.*/
                    $_SESSION['UserSession'] = false;   
                }

                // Direct customer to the home page
                header("Location: index.php");
                exit();

            } else {
                //if the password is incorrect echo a message to inform them
                /*the alert was taken from https://getbootstrap.com/docs/4.0/components/alerts/*/
                $delay =2;
                header("Refresh: $delay url =Login.php");
                echo "<div class='alert alert-danger'>Incorrect password!</div>";
            }
        } else {
            //if the email address wasn't found echo a message to inform them
            /*the alert was taken from https://getbootstrap.com/docs/4.0/components/alerts/*/
            $delay =2;
            header("Refresh: $delay url =Login.php");
            echo "<div class='alert alert-danger'>User not found!</div>";
        }
        // Closing the connections
        $stmt->close();
        $conn->close();
    }
?>