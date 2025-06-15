<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

        
include_once '../php-includes/connect.inc.php'; 


if (isset($_GET['UserID'])) {
        $var_AP_UserID = $_GET['UserID'];
    }

    if (isset($_GET['PMID'])) {
        $var_AP_PerID =  $_GET['PMID'];
    }
    
    if (isset($_GET['ONOFF'])) {
        $var_AP_ON_OFF =  $_GET['ONOFF'];
    }
    
    
       global $db;
    
    $PNo = $_GET['PageNo'];
    $TabNo = $_GET['tab'];
    $UserName = $_GET['UserName'];
    

    $stmt = $db->prepare("UPDATE cp_userpermission SET OnOff=? WHERE `permission_id`='$var_AP_PerID' AND `uid`='$var_AP_UserID' " );
    //i - integer / d - double / s - string / b - BLOB
    $stmt->bind_param('i', $var_AP_ON_OFF);
    $stmt->execute();
    $stmt->close(); 
    
if ($TabNo == 1){
   header('Location: ../index.php?page=AssignPermissions&UserID='. "$var_AP_UserID" . '&UserName='. "$UserName" . '&PageNo=' . "$PNo" . '&tab=1'); 
 
}  

if ($TabNo == 2){
   header('Location: ../index.php?page=AssignPermissions&UserID='. "$var_AP_UserID" . '&UserName='. "$UserName" . '&PageNo=' . "$PNo" . '&tab=2'); 
 
} 

if ($TabNo == 3){
   header('Location: ../index.php?page=AssignPermissions&UserID='. "$var_AP_UserID" . '&UserName='. "$UserName" . '&PageNo=' . "$PNo" . '&tab=3'); 
 
} 

if ($TabNo == 4){
   header('Location: ../index.php?page=AssignPermissions&UserID='. "$var_AP_UserID" . '&UserName='. "$UserName" . '&PageNo=' . "$PNo" . '&tab=4'); 
 
} 

if ($TabNo == 5){
   header('Location: ../index.php?page=AssignPermissions&UserID='. "$var_AP_UserID" . '&UserName='. "$UserName" . '&PageNo=' . "$PNo" . '&tab=5'); 
 
} 


// If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}



?>
