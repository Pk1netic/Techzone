<?php /*This is the navigation bar of our website. Only slight of the structure was taken from
"https://www.youtube.com/watch?v=PwWHL3RyQgk&t=403s". When it comes to the elements they were all done by 
Glory.

The header tag is used to define this script as the header of the html documents. nav is also used to define the navigation
bar of our header. It is sepperated from the logo to make the process of designing a responsive navigation bar easier.*/?>

<header>
        <!--Div used to align and design the 1st portion of the header (logo and hamburger menu button).
        The hamburger menu button is set to hidden in the css script and will only be shown in mobile mode.
        This is so that they can toggle the visibility of the navigation bar.-->
        <div class="align-logo">
            <a href="index.php" class="responsive-logo"><img class = "logo" src="images/TZ logo.png" alt=logo width="68" height="38"></a>
            <button id="menu" class="menu"><i class="fa-solid fa-bars fa-2xl"></i></button>
        </div>
        <nav class="show-navbar">
            <!--List used to design the shop and contact form hyperlinks-->
            <ul class ="nav_links">
                <li class="mid-links"><a href="Shop.php">Shop</a></li>
                <li class="mid-links"><a href="ContactForm.php">Contact us</a></li>
            </ul>

            <!--Div used to align the shopping cart and user account hyperlinks-->
            <div class="align">
                <ul class = "nav_links cart" >   
                    <li class="hidden"><i class="fa-regular fa-user"></i></li>
                    <li id="dropdown">
                        <a href = "#">
                    <?php
                        /*This script is used to  */ 
                        //if the user is logged in set "login" to the user's full name and implement a dropdown box containg hyperlinks to logout page and orders page
                        if(isset($_SESSION['loggedin'])==true){
                            echo $_SESSION['First_Name']." ". $_SESSION['Last_Name'];
                            /*logout.php is a script that destroys the user's session and directs them to the login page. The orders hyperlink is used to direct the user to the orders web page. this is implemented for 
                            authorised users as it's a service only provided for them.*/
                            echo 
                            '<ul class="dropdown" >
                                <li><a href="Logout.php">Log out</a></li> 
                                <li><a href="Orders.php">Orders</a></li>
                            </ul></a>';
                        }
                        //if user isn't logged in implement a login hyperlink and name it "login" so that there is a way for them to navigate to the login page.
                        else{
                            //A hyperlink named login which directs them to the login page once clicked
                            echo '<a href="Login.php">Login</a>';
                        }
                    ?> 
                    </li>
                </ul>

                <!--implementing the cart nav links-->
                <ul class = "nav_links cart">
                    <li><a href="Cart.php"><i class="fa-solid fa-cart-shopping"></i><span class="Show-cart">Shopping Cart</span></a></li>
                    <li class="hidden">
                    <?php
                    /*This script is used to output the number of products in the shopping cart onto the navigation bar.
                    If and else statements are used to output the cart quantity for the user whether they're authorised or not. */
                    
                    //connecting to the database
                    include_once 'connection.php';
                    
                    //binding the statement with an integer value (CartID) for either user
                    if(isset($_SESSION['loggedin'])==true){
                        /*Statement produced by Glory: preparing a select count statement to return the number of products in the cartitem table that matches the authorised user's cart
                        (needed to set and update cart quantity viewed in the navigation bar).*/                  
                        $sql = $conn->prepare("SELECT COUNT(*) FROM cartitem WHERE CartID = ?");
                        $sql->bind_param("i", $_SESSION['CartID']);#binding the cart ID of the user to the statement
                        $sql->execute(); //executing the query
                        $sql->bind_result($cartSize); //binding the result to a new variable called cartSize
                        $sql->fetch(); //fetching the result to it
                        $sql->close(); //closing the statement                  
                        echo $cartSize;  //echoing the size to display it on screen
                    }
                    else if(isset($_SESSION['UserSession'])==true){
                        /*Statement produced by Glory: preparing a select count statement to return the number of products in the cartitem table that matches the unauthorised user's cart
                        (needed to set and update cart quantity viewed in the navigation bar).*/ 
                        $sql = $conn->prepare("SELECT COUNT(*) FROM cartitem WHERE CartID = ?");
                        $sql->bind_param("i", $_SESSION['SessionCartID']); //binding the user's cart ID to the statement
                        $sql->execute(); //executing the query
                        $sql->bind_result($cartSize); //binding the result to a new variable called cartSize
                        $sql->fetch(); //fetching the result to it
                        $sql->close(); //closing the statement                  
                        echo $cartSize;  //echoing the size to display it on screen
                    }
                    //echo 0 if neither has been set yet
                    else{
                        echo '0';
                    }                           
                    ?>
                    </li>
                </ul>
            </div>
        </nav> 
</header>
<!-- including javascript made to enable the dropdownbox function (show and hide it) -->
<script type="text/javascript" src="Javascript/Dropdown.js"></script>

<!-- including Javasccript made to enable the dropdown function for the hamburger menu button in mobile mode -->
<script type="text/javascript" src="Javascript/navbar.js"></script>