<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//linked with companies.inc.php
include_once '../php-includes/connect.inc.php'; 

//Select multi recodes

// if search keyword is seet on URL....
 if(isset($_GET["SearchKey"])){
    
     
     
     $rowCount = count($_POST["check_list"]);

            for($i=0;$i<$rowCount;$i++) {


             
             //And then delete the recode form the table...
            $stmt = $db->prepare("DELETE FROM cp_Items WHERE id='" . $_POST["check_list"][$i] . "'");
            $stmt->execute(); 
            $stmt->close();
            //$stmt2->close();



            }
            

// We get page number to redirect the user to the same records page that the user entered..
$PageNo = $_GET["PageNo"];

//Jump to the same page after deleteing the image
header('Location: ../index.php?page=Items&PageNo=1'); 

//if NOT, 
 } else {
     
$rowCount = count($_POST["check_list"]);

            for($i=0;$i<$rowCount;$i++) {

             
            //And then delete the recode form the table...
            $stmt = $db->prepare("DELETE FROM cp_Items WHERE id='" . $_POST["check_list"][$i] . "'");
            $stmt->execute(); 
            $stmt->close();
            //$stmt2->close();





            }
            

// We get page number to redirect the user to the same records page that the user entered..
$PageNo = $_GET["PageNo"]; 
                       

//Jump to the same page after deleteing.
header('Location: ../index.php?page=Items&PageNo='. $PageNo); 

     
 }


        
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: ../login.php');
}



?>



