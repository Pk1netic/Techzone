<?php 
    /*using if statement to verify if the user navigated to the Orderdetails.php page via the view button and not through its URL.
    This is needed to prevent error messages from occuring as the data submitted from the form will be posted on this page*/

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['view'])){
            //including the database connection script so we can connect and execute the queries
            include_once 'PhpScripts/connection.php';

            //returning the ProductID posted from Orders.php form
            $orderId = $_POST["OrderID"];

            /*Statement produced by Ubayd: Preparing a select statement to return the total price of the order
            so that it can be appended to the page.*/
            $stmt = $conn -> prepare("SELECT TotalPrice FROM orders WHERE OrderID = ?");

            $stmt -> bind_param('i',$orderId); #binding the orderI id to the statement
            $stmt -> execute(); # executing the statement
            $stmt -> bind_result($TotalPrice); #binding the result to variable called TotalPrice
            $stmt -> fetch(); # fetching the result to the variable
            $stmt -> close(); # closing the statement to allow the next one to start.

            
            /*Statement produced by Ubayd: preparing a statement to return all fields from product, orderitem, 
            and orders table where the orderID is the one fetched from Orders.php form. It will be used to output
            the details of the order (stored in orderitem table) to the products table of this page.    */
            $stmt = $conn -> prepare("SELECT * FROM orders INNER JOIN orderitem ON orderitem.OrderID = orders.OrderID INNER JOIN product ON orderitem.ProductID = product.ProductID WHERE orders.OrderID = ?");
            $stmt -> bind_param('i',$orderId); #binding the order ID returned from Orders.php to the statement
            $stmt -> execute(); # executing the statement
            $result = $stmt -> get_result(); # storing the result to a variable named result.

            //storing the result as an associative array so that we can iterate through each order item and echo their details into the table
            $orderdetails = $result -> fetch_all(MYSQLI_ASSOC); 
            $stmt -> close(); #closing the statement
            $result -> close(); #closing the result statement

            /*This portion of the script is responsible for echoing the payment and shipping details of the order onto
            the delivery address and payment details table.*/

            /*Statement produced by Ubayd: preparing a select statement to return the payment, user and shipping details of the order. 4 tables have been joined which are user, payment, orders, and shippingaddress so that
            we can retrieve the payment and shipping details from their tables that match the IDs stored in the order from the right user.*/
            $stmt = $conn -> prepare("SELECT * FROM shippingaddress INNER JOIN orders ON shippingaddress.ShippingAddressID 
            = orders.ShippingAddressID INNER JOIN payment ON payment.PaymentID = orders.PaymentID INNER JOIN `user` ON user.UserID 
            = orders.UserID WHERE orders.OrderID = ?");
            
            $stmt -> bind_param('i',$orderId); #binding the order ID to the statement
            $stmt -> execute(); #executing the statement
            $result = $stmt->get_result(); # storing the result to a variable named result.

            //storing the result as an associative array so that we can iterate through each order item and echo their details into the table
            $details = $result -> fetch_all(MYSQLI_ASSOC);
            $stmt -> close(); #closing the statement
            $result -> close(); #closing the result statement
            
        }    
    }
    else{
        //if the view button hasn't been clicked direct user to the home page.
        header("Location: index.php");
    }
?>