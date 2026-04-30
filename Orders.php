<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders</title>
        <link rel="stylesheet" href="Stylesheets/NavigationBar.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s23160144_Glory.css" type="text/css">
        <link rel="stylesheet" href="Stylesheets/s22226102_Ubayd.css" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="Stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <?php
    //starting a session. This will be needed to enable all sessions to functions on this page
    session_start();

    if(isset($_SESSION['loggedin'])==true){
        //including the database connection script. Needed to enable query execution.
        require_once 'PhpScripts/connection.php';

        /*Statement produced by Ubayd: preparing a statement to retrieve all columns from the orders table that matches the user's ID.
        This is needed so that we can recursively echo the details of each order onto the table.*/
        $stmt = $conn -> prepare("SELECT * FROM orders WHERE UserID = ?");
        $stmt -> bind_param('i',$_SESSION['UserID']); #binding the user id to the statement
        $stmt -> execute(); #executing the statement
        $result = $stmt -> get_result(); #storing the result to a variable named result
        //storing the result as an associative array so that we can iterate through each order item and echo their details into the table
        $orders = $result -> fetch_all(MYSQLI_ASSOC);
        $stmt -> close(); #closing the statement
        $result -> close(); #closing the result
    }
    else{
        //if not logged and tries to get access to this page via url direct them to login page.
        header("Location: Login.php");
    }
    ?>
    <body>
        <!--The design of this page was made from scratch. Only the container styling is unoriginal as it was made by bootstrap-->

        <!--Including the navigation bar/header to the webpage-->
        <?php include_once 'PhpScripts/Header.php'; ?>
        <div class="container">
            <h4 class="AlignTitle">Orders</h4>
            <table class="table .thead-light orders-table">
                <tr class = "headings">
                    <th>ID</th>
                    <th>Tracking No</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>View</th>   
                </tr>
                <!--Recursively echoing details of all orders made-->
                <?php 
                if($orders > 0){
                    $ID = 1; //Row counter
                    foreach($orders as $orderRow){          
                    ?>
                    <Form action="Orderdetails.php" method ="POST">
                        <tr>
                            <td><?php echo $ID;?></td>
                            <td><?php echo $orderRow['TrackingNumber'];?></td>
                            <td>£<?php echo number_format($orderRow['TotalPrice'],2) ;?></td>
                            <td><?php echo $orderRow['OrderDate'] ;?></td>
                            <input type="hidden" name="OrderID" value="<?php echo $orderRow["OrderID"]; ?>"> 
                            <td><button type="submit" name="view" class="Addbtn save-remove-btn">View</button></td>        
                        </tr>
                    </Form>
                <?php
                        $ID +=1; #increasing the ID by 1 each loop
                    } //End of for loof
                } //end of if statement
                ?>
            </table>  
        </div>
        <!-- Appending the footer -->
        <?php include_once 'PhpScripts/Footer.php' ?>
    </body>
</html>