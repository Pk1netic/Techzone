<?php
/*This script is responsible for inserting the form data to the database and sending the user's message
to our email account (TechZoneBCU@gmail.com) */

//including the php mailer scripts to start a connection to the email server
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/*using if statement to verify if the user navigated to this page via the submit button and not through its URL.
This is needed to prevent error messages from occuring as data submitted from the form will be posted on the page*/
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // This script is used to insert the details submitted from the form (via submit button) to the form table in our database and to our email address (techzonebcu@gmail.com).
    if(isset($_POST["submit"])){

        //retrieving data posted from the form
        $fName = $_POST['Fname'];
        $lName = $_POST["Lname"];
        $reasoning = $_POST["reasoning"];
        $message = $_POST["message"];

        //setting up a connection to smtp email server to allow the mail to be sent to our email.
        //reference to this script came from "https://github.com/PHPMailer/PHPMailer?tab=readme-ov-file".
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail->Username = 'TechZoneBCU@gmail.com'; #the name of our email address
        $mail->Password = 'zkay finf hrsz gaua'; #the app password of our email
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        if(isset($_SESSION['loggedin'])==true){
            $mail->setFrom($_SESSION["Email_Address"]);
        }
        else{
            $mail->setFrom($_POST["email"]);
        }
        $mail->addAddress('TechZoneBCU@gmail.com');
        $mail->Subject = $reasoning;    
        $mail->Body=$message;
        $mail->send();
        
        //using try and catch clauses to catch any errors trying to insert the details to the contact form table.
        try{
            //including database connection to enable the statements to execute by connecting to it.
            require_once 'PhpScripts/connection.php';

            //using if and else statements to insert appropiate details to the form depending on the type of user that submitted the form (unauthenticated or authorised users).
            if(isset($_SESSION['loggedin'])==true){

                /*Statement produced by Yusuf: preparing a statement to insert the data submitted from the form to the contactform table. Need to be prepared to prevent SQL injection.
                This needs to be done to backup the messages incase it accidently gets deleted.*/
                $stmt = $conn->prepare("INSERT INTO contactform (UserID, First_Name, Last_Name, Reasoning, Message) VALUES (?,?,?,?,?)");
                $stmt -> bind_param('issss',$_SESSION['UserID'],$fName,$lName,$reasoning,$message); #binding the parameters to the statement.
                $stmt -> execute(); #executing the query
                $stmt -> close(); #closing the statement
            }
            else{
                //returning email posted from the form. Will be needed to provide us a way of contacting the customer
                $Email = $_POST["email"]; 
                /*Statement produced by Yusuf: preparing a statement to insert the data submitted from the form to the contactform table. Need to be prepared to prevent SQL injection.
                This needs to be done to backup the messages incase it accidently gets deleted. unlike logged in users this form also inserts the email address to the table
                so that we know which email the message was sent by.*/
                $stmt = $conn->prepare("INSERT INTO contactform (First_Name, Last_Name, Email_Address, Reasoning, Message) VALUES (?,?,?,?,?)");
                $stmt -> bind_param('sssss',$fName,$lName,$Email,$reasoning,$message); #binding the parameters to the statement.
                $stmt -> execute(); #executing the statement
                $stmt -> close(); #closing the statement
            }
        }
        catch(mysqli_sql_exception $err){
            //if an error was caught then output an exception error message.
            return $err;
        }
    }
}
else{
    //if the submit button hasn't been clicked direct user to the home page.
    header("Location: index.php");
}
?>