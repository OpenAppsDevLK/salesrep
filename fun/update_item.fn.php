<?php

 // Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];  
        
        
//Call in edititem.inc.php

include_once '../php-includes/connect.inc.php';  


function UpdateItemDetails(){
 
    if(isset($_POST['btn_UpdateItem'])){
        
     if (isset($_POST['txt_item_ID'])) {
           $var_item_id = $_POST['txt_item_ID'];     
    }
     
    if (isset($_POST['txt_item_code'])) {
           $var_item_code = $_POST['txt_item_code'];     
    }


    if (isset($_POST['txt_item_name'])) {
        $var_item_name =  $_POST['txt_item_name'];
    }
    
    if (isset($_POST['txt_item_notes'])) {
    $var_item_notes = $_POST['txt_item_notes'];
    }
    
    if (isset($_POST['txt_cost_price'])) {
    $var_cost_price = $_POST['txt_cost_price'];
    }
    
    if (isset($_POST['txt_sales_price'])) {
    $var_sales_price = $_POST['txt_sales_price'];
    }
    
    
       global $db;

    $stmt = $db->prepare("UPDATE cp_Items SET item_code=?, name=?, notes=?, cost_price=?, sale_price=? WHERE `id`='$var_item_id'" );
    //i - integer / d - double / s - string / b - BLOB
    $stmt->bind_param('sssdd', $var_item_code, $var_item_name, $var_item_notes, $var_cost_price, $var_sales_price);
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