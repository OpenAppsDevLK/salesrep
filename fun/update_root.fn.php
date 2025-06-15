<?php

 // Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];  
        
        
//Call in Update_root.inc.php

include_once '../php-includes/connect.inc.php';  


function updaterootdetails(){
 
    if(isset($_POST['btn_updateroot'])){
        
 
     
    if (isset($_POST['txt_root_AutoID'])) {
      $var_root_ID_auto = $_POST['txt_root_AutoID'];     
    }


    if (isset($_POST['txt_root_id'])) {
        $var_root_id =  $_POST['txt_root_id'];
    }
    
    if (isset($_POST['txt_root_name'])) {
    $var_root_name = $_POST['txt_root_name'];
    }
    
    if (isset($_POST['txt_root_notes'])) {
    $var_root_address = $_POST['txt_root_notes'];
    }
    
    
       global $db;

    $stmt = $db->prepare("UPDATE cp_root SET id=?, root_id=?, root_name=?, root_notes=? WHERE `id`='$var_root_ID_auto'" );
    //i - integer / d - double / s - string / b - BLOB
    $stmt->bind_param('iiss', $var_root_ID_auto, $var_root_id, $var_root_name, $var_root_address);
    $stmt->execute();
    $stmt->close(); 
    

    
    return($stmt);
    
    
      }
      
   }
    
  
    
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}


    
    
?>