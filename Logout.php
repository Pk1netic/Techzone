<!--This script logs the user out of their account. To do this a session is created and then destroyed
to ensure that their session has ended. This will restrict access to their account unless they login again-->

<?php
//starting a session
session_start();

//destroying the session then directing them to the login page
session_destroy();
header("location: Login.php");
?>