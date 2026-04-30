<?php
/*This script will be used to execute and connect all sql scripts to the database*/

//setting variables that store the network, user, and database details to enable its connection
$hostName = "127.0.0.1";
$username = "admin";
$Password = "Jayzee12345";
$db_name = "Group68_DB";

//connecting to database using mysqli function
$conn = new mysqli($hostName,$username,$Password,$db_name);

//checking for connection errors
if($conn -> connect_error){
    die("Connection failed: ".$conn -> connect_error);
}
?>