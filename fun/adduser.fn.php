<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//Call in adduser.inc.php

include_once '../php-includes/connect.inc.php'; 


function adduser(){
    

 
    if(isset($_POST['btn_submit'])){
        
       
    if (isset($_POST['txt_AU_AutoID'])) {
        $var_AU_AutoID = $_POST['txt_AU_AutoID'];
    }

    if (isset($_POST['txt_AU_username'])) {
        $var_AU_username = $_POST['txt_AU_username'];
    }
    
    if (isset($_POST['txt_AU_pass'])) {
        $var_AU_Pass = sha1($_POST['txt_AU_pass']);
    }
    
    if (isset($_POST['txt_AU_Fname'])) {
    $var_AU_Fname = $_POST['txt_AU_Fname'];
    }
    
    if (isset($_POST['txt_AU_LName'])) {
    $var_AU_Lname = $_POST['txt_AU_LName'];
    }
    
    if (isset($_POST['txt_rep_id'])) {
    $var_rep_id = $_POST['txt_rep_id'];
    }
    
    if (isset($_POST['txt_can_see_inv'])) {
    $var_can_see_inv = $_POST['txt_can_see_inv'];
    }    
    
       global $db;
   

    $stmt2 = $db->prepare("INSERT INTO `cp_userpermission` (permission_id, uid, OnOff) VALUES (1111, '$var_AU_AutoID', 1), (1112, '$var_AU_AutoID', 1), (1113, '$var_AU_AutoID', 1), (1114, '$var_AU_AutoID', 1), (1115, '$var_AU_AutoID', 1), (1116, '$var_AU_AutoID', 0),(1130, '$var_AU_AutoID', 0),(1117, '$var_AU_AutoID', 0),(1118, '$var_AU_AutoID', 0),(1119, '$var_AU_AutoID', 0),(1120, '$var_AU_AutoID', 0),(1129, '$var_AU_AutoID', 0),(1123, '$var_AU_AutoID', 0),(1124, '$var_AU_AutoID', 1),(1125, '$var_AU_AutoID', 0),(1127, '$var_AU_AutoID', 0), (1128, '$var_AU_AutoID', 0), (1121, '$var_AU_AutoID', 0),(1122, '$var_AU_AutoID', 0)");
    //i - integer / d - double / s - string / b - BLOB
    $stmt2->execute();
    $stmt2->close(); 
    
    
    $stmt1 = $db->prepare("INSERT INTO `cp_users` (id, username, password, firstname, lastname, rep_id, can_view_all_inv) VALUES (?, ?, ?, ?, ?, ?, ?)" );
    //i - integer / d - double / s - string / b - BLOB
    $stmt1->bind_param('issssii', $var_AU_AutoID, $var_AU_username, $var_AU_Pass, $var_AU_Fname, $var_AU_Lname, $var_rep_id, $var_can_see_inv);
    $stmt1->execute();
    $stmt1->close(); 
        
    $stmt3 = $stmt2 ;
    $stmt3 = $stmt1;
    
 
    
    return($stmt1);
    
    
      }
     
   }
    
  
  
        // If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}


    
    
    
?>