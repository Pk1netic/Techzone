<?php
    /*  Group Member(s) contribution to creating the sql scripts:
        1. Glory Iloba

        This script is responsible for updating product quantity, saving products, adding products back to the cart, and
        deleting products from the cart. Additonally it also prevents unauthorised users from proceeding to the checkout page
        to enhance security (shipping and payment details), and user experience (easily track their orders via order history which is only
        available for authenticated users, and solving orders inquiries).

        All queries uses prepared statements to prevent SQL injections (which is a form of attack that allows attackers to interfere with them) to enhance security.
    */

    /*using if statement to verify if the user navigated to the Checkoutsuccess.php page via the checkout button and not through its URL.
    This is needed to prevent error messages from occuring as data submitted from the form will be posted on the page*/

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['checkout'])){
            //including the database connection script
            include_once 'PhpScripts/connection.php';

            //retrieving shipping details returned from the form
            $housenumber = $_POST['HouseNum'];
            $StreetRoad = $_POST['str/rd'];
            $TownCity = $_POST['town/city'];
            $County = $_POST['County'];
            $Postcode = $_POST['Postcode'];

            //retieving payment details submitted from the form.
            $cardNum = $_POST['cardNum'];
            $expDate = $_POST['expDate'];
            $cardHName = $_POST['cardHName'];
            $CVC = $_POST['CVC'];
        
            /*Query produced by Glory: preparing an insert statement to insert the shipping data captured from the form to the shippingaddress table. 
            This needs to be done to not only update the user's shipping address but to also append its ID to their order.*/
            $stmt = $conn -> prepare("INSERT INTO shippingaddress (House_Number, `Street/Road`, `Town/City`, County, Postcode) VALUES (?, ?, ?, ?, ?)");
            
            //binding the details retrieved from the database to the query
            $stmt -> bind_param('issss',$housenumber,$StreetRoad,$TownCity,$County,$Postcode);
            
            //executing the statement
            $stmt->execute();
            
            //returning the shipping address ID of shipping address inserted to the dafabase using insert_id function;
            $ShippingID = $conn->insert_id;
            
            /*creating a variable to mask the credit card number leaving the final 4 digits feasible. 
            This is done to secure the card details and be able to return the final 4 numbers of the card to define what card was used for an order.
            This was the only way I could find out how to encrypt a card and still be able to retrieve its details.*/
            $last_four_nums = 'XXXX-XXXX-XXXX-'.substr($cardNum, -4);

            //hashing the CVC for security reasons. I will be using hash() function with sha256 hash code which creates a 64 digit hexadecimal number.
            $CVC = hash('sha256', $CVC);
            
            /*Query produced by Glory: Preparing a statement to insert the payment details to the payment table. 
            This will also be used to update the user's paymentId and to add it to the order so that it can be viewed in their order history*/
            $sql = $conn -> prepare("INSERT INTO payment (Card_Number, Card_Expiring_Date, Card_Holder_Name, CVC) VALUES (?,?,?,?)");
            
            //binding the result
            $sql->bind_param('ssss',$last_four_nums, $expDate, $cardHName, $CVC);
            
            //executing the statement
            $sql -> execute();
            
            //returning the payment ID of the newly inserted payment record using insert_id function.
            $paymentID = $conn->insert_id;

            //closing both statements
            $stmt -> close();
            $sql -> close();

            /*Statement produced by Glory: preparing an update statement so that we can update the user's paymentID and ShippingAddressID to the IDs of the payment and shippingaddress records created.
            This statements intakes 3 arguements to ensure that the right payment and shipping address are updated for the right user which are:
                1. PaymentID: Id of the payment record created earlier
                2. ShippingAddressID: Id of the shipping address record created earlier
                3. UserID: ID of the user to change their payment and shipping address to*/
            $stmt = $conn -> prepare("UPDATE user SET PaymentID = ?, ShippingAddressID = ? WHERE UserID = ?");
            
            //binding the parameters with the payment ID and Shipping address ID retrieved and the ID of the user
            $stmt -> bind_param("iii",$paymentID,$ShippingID,$_SESSION['UserID']);

            //storing the result
            $stmt -> store_result();

            //checking if the statement executes
            if($stmt -> execute()){

                //closing the statement to allow the next to start
                $stmt -> close(); 

                /*Query produced by Glory: Using Select and Inner join statements to accurately retrieve the price and quantity of each product purchased
                so that we can calculate the overall price of the order and append it to the order record to be produced so that it can be viewed in their order hsitory.
                The record selects all from the cartitem and product tables where product IDs match which I then joined it with the cart table where the cartid matched the cartid 
                inserted in the cartitem table and then used a where clause to accuratelly retrieve the quantity and product from the tables where the userID of the cart is equal to the one of the customer.
                Additionally the records returned from this statement will later be used to add some of its details to the orderitem table and delete the product from their cart.*/
                
                $stmt2 = $conn->prepare("SELECT * FROM product INNER JOIN cartitem ON cartitem.ProductID = product.ProductID INNER JOIN cart ON cart.CartID = cartitem.CartID WHERE cart.UserID = ?");
                $stmt2 -> bind_param('i',$_SESSION['UserID']); #binding the UserID to the sql query as integer.
                $stmt2 -> execute(); #executing the sql query
                $result = $stmt2->get_result(); #storing the result to $result variable
                $Products = $result->fetch_all(MYSQLI_ASSOC); #fetching all rows
                $overallPrice = 0; #variable to store the overall price
                foreach($Products as $row){
                    //multiplying the price and quantity then add it to the value attached to the overallprice variable
                    $overallPrice += ($row['Price'] * $row['Quantity']); 
                }

                /*Statement produced by Glory: preparing an insert into statement to insert the order details to the orders table so that we can use the record to view the details of the order in the user's order history.
                The statement requires a tracking number, and order date which will later be produced and binded to the statement.*/
                $stmt = $conn -> prepare("INSERT INTO orders (TrackingNumber, UserID, OrderDate, TotalPrice, ShippingAddressID, PaymentID)
                VALUES (?,?,?,?,?,?)");

                //preparing the parameters to be binded
                $date = date("Y-m-d"); #date the order was made in year-month-date format.
                $trackingNum = uniqid(); #creating a random tracking number using uniqid.
                
                //binding the traking number, user id, date of order, overall price, shipping address id and payment id to the prepared statement.
                $stmt -> bind_param('sisdii',$trackingNum,$_SESSION["UserID"],$date,$overallPrice,$ShippingID,$paymentID);
                $stmt -> execute(); #executing the statement
                $stmt2 -> close(); #closing connection

                /*Query produced by Glory: preparing a statement to select the orderID from the orders table where the user ID is equal to the one of the customer, 
                and shipping address id and payment id are equal to the one i just created.This is needed so that we can add it to the orderitem table.*/
                $stmt2 = $conn -> prepare("SELECT OrderID FROM orders WHERE UserID = ? AND ShippingAddressID = ? AND PaymentID = ?"); #preparing statement
                $stmt2 -> bind_param('iii',$_SESSION['UserID'], $ShippingID, $paymentID); #binding parameters
                $stmt2 -> execute(); #executing the query
                $stmt2 -> bind_result($OrderID); #binding the result to a new variable called OrderID
                $stmt2 -> fetch(); #fetching the result
                $stmt2 -> close(); #closing connection

                /*now adding all product/order details to the order. I am using the same details fetched from the join table (around line 92);
                I'll be using a for loop to iterate through the associative array to recursively add all product details of the order to the orderitem table. and then removing them from their shopping cart to clear it*/
                foreach($Products as $product){
                    $priceAtOrder = ($product['Price']*$product['Quantity']); #calculating the price of product at order
                    
                    //Statement produced by Glory: Preparing an insert into statement to insert the order details to the orderitem table.
                    $stmt = $conn -> prepare("INSERT INTO orderitem (OrderID, ProductID, Quantity, PriceAtOrder) VALUES (?,?,?,?)");
                    $stmt -> bind_param("iiid",$OrderID,$product['ProductID'],$product['Quantity'],$priceAtOrder); #binding the order ID and entried fetched from $Products array
                    $stmt -> execute();#executing query
                    $stmt -> close();#closing query

                    //Statement produced by Glory: preparing a delete statement to remove the product from the user's cart to clear it.
                    $query = $conn -> prepare("DELETE FROM cartitem WHERE CartID = ? AND ProductID = ?");
                    $query -> bind_param('ii',$_SESSION['CartID'],$product["ProductID"]);
                    $query -> execute();
                    $query -> close();
                }

                /*Statement produced by Glory: preparing a Select statement to read and return the order and user details so that they can be implemented in the form's success message.
                Inner joins were used were used to do this (combines user and orders table) and where clauses were included to accurately retrieve the order details from the right user and order*/
                $stmt = $conn->prepare("SELECT Email_Address, First_Name, Last_Name, TotalPrice FROM `user` INNER JOIN orders ON user.UserID = orders.UserID WHERE orders.ShippingAddressID = ? AND orders.PaymentID = ? AND user.UserID = ?");
                $stmt -> bind_param('iii',$ShippingID,$paymentID,$_SESSION['UserID']); #binding the shipping address ID, paymeng ID, and User ID to the statement
                $stmt -> execute(); # executing the statement
                $result = $stmt->get_result(); # creating a variable named $result to store the result of the statement to it.

                //creating a variable to store the result as an associative array. This will be used to echo the details onto the form's success message.
                $orderdetails = $result -> fetch_all(MYSQLI_ASSOC); 
                
            }
            else{
                //if the query statement can't execute echo an error message
                echo "error caught: ".$conn->error();
            }                
        }
        else{
            //if the checkout button hasn't been clicked direct user to the home page.
            header("Location: index.php");
        }
    }
    else{
        //if the submit button hasn't been clicked direct user to the home page.
        header("Location: index.php");
    }
?>