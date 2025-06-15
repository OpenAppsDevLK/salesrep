<?php


// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//Call in rep.inc.php

include_once '../php-includes/connect.inc.php'; 

function addrep(){

if(isset($_POST['btn_rep_submit'])){
    
   
 
    
    if (isset($_POST['txt_rep_AutoID'])) {
      $var_rep_ID_auto = $_POST['txt_rep_AutoID'];     
    }
   
    if (isset($_POST['txt_rep_name'])) {
    $var_rep_name = $_POST['txt_rep_name'];
    }
    
    if (isset($_POST['txt_rep_address'])) {
    $var_rep_address = $_POST['txt_rep_address'];
    }
    
    if (isset($_POST['txt_rep_mob01'])) {
    $var_rep_mob01 = $_POST['txt_rep_mob01'];
    }
    
    if (isset($_POST['txt_rep_mob2'])) {
    $var_rep_mob02= $_POST['txt_rep_mob2'];
    }
    
    if (isset($_POST['txt_rep_notes'])) {
    $var_rep_notes= $_POST['txt_rep_notes'];
    }   
  
    
 global $db;
    
    $stmt = $db->prepare("INSERT INTO `cp_rep` (id, rep_name, rep_address, rep_mob1, rep_mob2, rep_notes) VALUES (?, ?, ?, ?, ?, ?)" );
    //i - integer / d - double / s - string / b - BLOB
    $stmt->bind_param('issiis', $var_rep_ID_auto, $var_rep_name, $var_rep_address, $var_rep_mob01, $var_rep_mob02, $var_rep_notes);
    $stmt->execute();
    $stmt->close();
    
    
    
     

    
       //Redirect to the page after inset 
   echo "<script>location='index.php?page=Rep&PageNo=1'</script>";
   
   return($stmt);
    
   }
    
  }  
    
    
// If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}


    
?>