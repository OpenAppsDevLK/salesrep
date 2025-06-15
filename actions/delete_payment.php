<?php
// Browser Session Start here
//session_start();
//if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
//	$user = $_SESSION['user_name'];
//        
//        
//
////include
//include_once '../php-includes/connect.inc.php';  
//
//if (isset($_GET['TransID'])) {    // GET instead of POST for value in the URL
//    $Cdt_trn_ID = $_GET['TransID']; // only id is needed - delete other variable assignments
//    $Cdt_Page = $_GET['ViewInvoice'];
//    $PageNo = $_GET['PageNo'];
//    $InvID = $_GET['InvID'];
//   
//   }
//   
//
//        $stmt = $db->prepare("DELETE FROM `cp_inv_payment` WHERE `id` = ?");
//        $stmt->bind_param('i', $Cdt_trn_ID);
//        //$stm->bind_result($id, $bookName, $bookDescription);
//        $stmt->execute(); 
//        $stmt->close();
//
//
//      //Calulate Sum of total Credit Notes Amount
//                    $Total_cdt_amount1 = $db->prepare("SELECT (SUM(cash_amount)+SUM(cheq_amount)) FROM cp_inv_payment WHERE p_inv_id=$InvID");
//                    $Total_cdt_amount1->bind_result($Total_cdt);
//                    $Total_cdt_amount1->execute();
//
//                    while ($Total_cdt_amount1->fetch()){
//
//                      $Total_cdt = number_format($Total_cdt, 2, '.', '');  
//
//
//                      }
//  
//            // Update Credit Amont after delete
//            $stmt_update_total_cd = $db->prepare("UPDATE cp_invoice SET inv_total_pd_amt=? WHERE `id`='$InvID'" );
//            //i - integer / d - double / s - string / b - BLOB
//            $stmt_update_total_cd->bind_param('d', $Total_cdt);
//            $stmt_update_total_cd->execute();
//            $stmt_update_total_cd->close(); 
//            
//         $stmt3 = $stmt;
//         $stmt3 = $stmt_update_total_cd;
//         
//        
//       //Jump to the same page after deleteing the image
//        header('Location: ../index.php?page=ViewInvoice&InvID='.$InvID.'&PageNo='.$PageNo); 
//        
//        return($stmt3);      
//        
//  // If session isn't meet, user will redirect to login page
//} else { 
//    header('Location: ../login.php');
//}

    
    
    ?>
