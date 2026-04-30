<?php 
    /*The purpose of this script is to enable the user to create an account. The details submitted from the form
    implemented in registration.php are posted in this script.*/
    
    if (isset($_POST["registration"])) {
        //including connection.php file to enable this script to connect to the database
        require_once 'PhpScripts/connection.php';

        /*query produced by Glory: Preparing an insert query statement to insert the details submitted from the form to the user table.
        This needs to be done to create an account for the user. Additonally the statement is prepared to prevent SQL injection which is 
        necessary as the details are highly sensitive that it could lead to unauthorised access to the account via the email and password provided. 
        The statement intakes 5 arguements which are:
        1. first_name: the first name of the user
        2. last_name: the last name of the user
        3. Email_Address: the email address of the user
        4. Phone_Number: the phone number of the user (it can be null as it's no needed)
        5. password: the password created for the account (the password is hashed using hash_password function to encrypt it)*/
        
        $stmt = $conn->prepare(
            "INSERT INTO user (First_Name, Last_Name, Email_Address, Phone_Number, password) VALUES (?, ?, ?, ?, ?)"
        );

        //Binding the parameters returned from the submitted file to the SQL statement
        $stmt->bind_param("sssss", $firstname, $lastname, $email,$phonenumber,$password);

        //Returning the data submitted from the form
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phonenumber = $_POST["phonenumber"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Hashing the password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        /*query produced by Glory: preparing a select statement to read and return the number of rows that match the email address submitted via the form.
        This is needed to verify if the account can be created as an email address can only be unique to one user so if there's one present it doesn't be created.*/
        $sql = $conn ->prepare("SELECT * FROM user WHERE Email_Address = ?");
        
        //binding and executing the query.
        $sql -> bind_param('s',$email);
        $sql -> execute();

        //fetching the result from the query to a variable named result
        $result = $sql->get_result();         
        

        //if the email is already present in the user table echo an error message stating that it already exists in the system.
        if ($result -> num_rows > 0){
            echo "<div class='alert alert-danger'>email already exist</div>";  
        }
        //if the email isn't present proceed to creating their account
        else{
            //closing $sql statement
            $sql->close();

            //Executing the SQL statement and checking if it can execute if not echo an error
            if ($stmt->execute()) {
                //if executed show output a success message. and then refresh and send the user to the login page so that they can log into their account.
                $delay =1;
                header("Refresh: $delay url =Login.php");
                echo "<div class= 'alert alert-success'>Account registered successfully.</div>";
            } else {
                //if failed to execute output an error indicating its failure.
                echo "error: ".$conn->error();
            }
        }

        // Closing the connection and statement
        $stmt->close();
        $conn->close();

    }
?>