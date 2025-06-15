<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//linked with edituser.inc.php

//include
include_once '../php-includes/connect.inc.php'; ; 

if (isset($_GET['UserID'])) {    // GET instead of POST for value in the URL
   $VarUserID = $_GET['UserID']; // only id is needed - delete other variable assignments
    
   }
   


        $stmt = $db->prepare("DELETE FROM `cp_users` WHERE `id` = ?");
        $stmt->bind_param('i', $VarUserID);
        $stmt->execute(); 
        //$stmt->close();

        $stmt2 = $db->prepare("DELETE FROM `cp_userpermission` WHERE `uid` = ?");
        $stmt2->bind_param('i', $VarUserID);
        $stmt2->execute(); 
        
        $stmt->close();
        $stmt2->close();       
        
       //Jump to the same page after deleteing the image
        header('Location: ../index.php?page=ViewAllUsers&PageNo=1'); 
        
        
 
      // If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}


    
    ?>
