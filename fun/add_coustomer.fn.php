<?php


// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//Call in customers.inc.php

include_once '../php-includes/connect.inc.php'; 

function AddCustomer(){

if(isset($_POST['btn_com_submit'])){
    
   
 
    
    if (isset($_POST['txt_com_AutoID'])) {
       $var_com_ID_auto = $_POST['txt_com_AutoID'];     
    }


    if (isset($_POST['txt_com_id'])) {
        $var_com_id =  $_POST['txt_com_id'];
    }
    
    if (isset($_POST['txt_com_name'])) {
    $var_com_name = $_POST['txt_com_name'];
    }
    
    if (isset($_POST['txt_com_tele'])) {
    $var_com_tele = $_POST['txt_com_tele'];
    }
    
    if (isset($_POST['txt_com_address'])) {
    $var_com_Address = $_POST['txt_com_address'];
    }
    
    if (isset($_POST['txt_com_notes'])) {
    $var_com_notes= $_POST['txt_com_notes'];
    }
    
   
  
    
 global $db;
    
    $stmt = $db->prepare("INSERT INTO `cp_customers` (id, com_id, com_name, com_tele, com_address, com_notes) VALUES (?, ?, ?, ?, ?, ?)" );
    //i - integer / d - double / s - string / b - BLOB
    $stmt->bind_param('iisiss', $var_com_ID_auto, $var_com_id, $var_com_name, $var_com_tele, $var_com_Address, $var_com_notes);
    $stmt->execute();
    $stmt->close();
    
    
    
     

    
       //Redirect to the page after inset 
   echo "<script>location='index.php?page=Customers&PageNo=1'</script>";
   
   return($stmt);
    
   }
    
  }  
    
    
// If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}


    
?>