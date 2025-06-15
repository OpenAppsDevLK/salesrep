<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

}

// Browser Session Ends here
    session_destroy();
    

// Redirect to login.php  
    header('Location: login.php');
   


?>