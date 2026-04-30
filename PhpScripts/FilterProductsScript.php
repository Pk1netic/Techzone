<?php
    //Checking if any categories have been checked if so execute the if statement
    if(isset($_GET['categories'])){
        //inserting all checked categories to the categorychecked array
        $categorychecked = array();
        $categorychecked = $_GET['categories'];
        
        /*Query produced by glory:Creating a query to return all products that match the categories checked by the user.
        I used implode to split the categories stored in categorychecked array*/
        $sql = "SELECT * FROM product WHERE Category IN ('".implode("','", $categorychecked)."')";

        /*connecting the query to the database and executing it then storing it to a variable named "products".
        This variable will be used to recursively create and list the products retrieved from the query on screen.*/
        $products = $conn->query($sql);    
    }
    //if no categories have been checked then the else statement will execute.
    else{
        //query made by glory: Selecting all collumns from the product table. will be used to recursively create product card for each product in the table.
        $sql = "SELECT * FROM product";

        /*connecting the query to the database and executing it then storing it to a variable named "products".
         This variable will be used to recursively create and list the products retrieved from the query on screen.*/
        $products = $conn->query($sql);
    }
?>