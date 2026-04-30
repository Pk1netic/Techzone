<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order details</title>
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
    //including the script for this page
    include_once 'PhpScripts/OrderDetailsScript.php';
    ?>

    <!--The layout and design was made from scratch-->
    <body>
        <!--Including the header/navigation bar to the page-->
        <?php require_once 'PhpScripts/Header.php';?>

        <!--The design of this page was made from scratch. Only the container styling is unoriginal as it was made by bootstrap-->
        <div class="container">
            <h4>Order details</h4>
            <table class="table .thead-light orders-table">
                <tr class = "headings">
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>   
                </tr>
                <!--Recursively echoing the product details to the table-->
                <?php 
                //the order details variable was extracted from the OrderDetailsScript.php script
                if($orderdetails > 0){
                    foreach($orderdetails as $orderRow){          
                    ?>
                <tr>
                    <td><img class = "product-image" src="<?php echo $orderRow["Image"];?>" alt=productImg></td>
                    <td><?php echo $orderRow['Name'] ;?></td>
                    <td>£<?php echo number_format($orderRow['Price'],2) ;?></td>
                    <td><?php echo $orderRow['Quantity'] ;?></td>
                    <td>£<?php echo number_format($orderRow['PriceAtOrder'],2)?></td>     
                </tr>
                <?php
                    } //End of for loof
                } //end of if statement
                ?>
            </table>
            <p class="price-align">Total: £<?php echo number_format($TotalPrice, 2); ?><p>

            
            <h4>Shipping and Payment Details</h4>
            <table class="table .thead-light details-table">
                <tr class = "headings">
                    <th class="align-th">Shipping</th>
                    <th class="align-th">Payment</th>
                </tr>
                
                <!--Recursively echoing the payment and shipping details onto the table-->
                <tr>
                    <?php
                        //the details variable was extracted from the OrderDetailsScript.php script
                        if ($details > 0){
                            foreach($details as $row){
                        ?>
                    <td>           
                        <ul class="align-list">
                            <li>Customer's Name: <?php echo $row['First_Name']." ". $row['Last_Name'];?></li>
                            <li>House Number: <?php echo $row['House_Number'];?></li>
                            <li>Street/Road: <?php echo $row['Street/Road'];?></li>
                            <li>Town/City: <?php echo $row['Town/City'];?></li>
                            <li>Postcode: <?php echo $row['Postcode'];?></li>
                            <?php 
                            if($row['County'] != null){
                                 echo '<li>County: '.$row['County'].' </li>';
                            }
                            ?>
                        </ul>
                    </td>
                    <td>
                        <ul class="align-list">
                            <li>Card Ending With: <?php echo substr($row["Card_Number"], -4);?></li>
                            <li>Card Holder Name: <?php echo $row["Card_Holder_Name"];?></li>
                        </ul>
                    </td>
                    <?php 
                        }//end of for loop
                    }//end of if statement
                    ?>     
                </tr>
            </table>          
        </div> <!-- end of container -->
        <?php require_once 'PhpScripts/Footer.php';?>
    </body>
</html>