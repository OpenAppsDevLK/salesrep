<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
        
        
//includes Files
include_once '../php-includes/connect.inc.php';
include_once 'php-includes/header.inc.php';
include_once 'php-includes/topnav.inc.php';
include_once 'php-includes/get-var.inc.php';
include_once 'php-includes/sidebarleft.inc.php'; 



$stmt1121 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1121" ); 
$stmt1121->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1121->execute();

while ($stmt1121->fetch()){ 
    
}

?>

<?php

            

            
?>




      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
 <?php
 
            $stmt2 = $db->prepare("SELECT id, firstname, lastname FROM `cp_users` WHERE id= {$_SESSION['user_id']}"); 
            $stmt2->bind_result($id, $FirstName, $LastName);
            $stmt2->execute();
            
            while ($stmt2->fetch()){ 
                
            }
            
    if ($cp_userpermission_OnOff == 0){

        $Message = "<h1>";
        $Message .= "Welcome $FirstName...!!";
        $Message .= "</h1>";
        echo $Message;
        
    } else {
            
            
?>
            <h1>
        
            Dashboard
            
       <?php
       
            $stmt = $db->prepare("SELECT id, firstname, lastname FROM `cp_users` WHERE id= {$_SESSION['user_id']}"); 
            $stmt->bind_result($id, $FirstName, $LastName);
            $stmt->execute();
            
            while ($stmt->fetch()){ 
             
       ?>
            
            <small>Hi.. <?php echo $FirstName ?>, Welcome to SalesRep ADMIN area..!!</small>
            
            
            <?php
            }
            ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">

            <?php

            // Prepare statement to count outstanding invoices (is_paid = 0)
            $Total_Outstanding_Invoices = $db->prepare("SELECT COUNT(inv_id) FROM cp_invoice WHERE is_paid = 0");
            $Total_Outstanding_Invoices->bind_result($TotalOutstandingInvoices);
            $Total_Outstanding_Invoices->execute();
            $Total_Outstanding_Invoices->fetch();
            $Total_Outstanding_Invoices->close();

            // Prepare statement to sum total outstanding amount
            $amount_sql = "SELECT COALESCE(SUM(outstanding_amount), 0) AS total_amount
                           FROM (
                               SELECT i.inv_id, GREATEST(i.inv_grand_total - COALESCE(SUM(p.cash_amount + p.cheq_amount), 0), 0) AS outstanding_amount
                               FROM cp_invoice i
                               LEFT JOIN cp_inv_payment p ON i.inv_id = p.p_inv_id
                               WHERE i.is_paid = 0
                               GROUP BY i.inv_id
                           ) AS subquery";
            $amount_stmt = $db->prepare($amount_sql);
            $amount_stmt->execute();
            $amount_stmt->bind_result($total_amount);
            $amount_stmt->fetch();
            $amount_stmt->close();
            ?>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-list-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Outstanding Invoices</span>
                        <span class="info-box-number"><?php echo $TotalOutstandingInvoices; ?> Invoices</span>
                        <span class="info-box-number">Rs <?php echo number_format($total_amount, 2); ?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->    
            
            
          </div><!-- /.row -->

          <div class="row">   

          </div><!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- MAP & BOX PANE -->
          
              
              <div class="row">
                <div class="col-md-6">
                 
                    
                  
                </div><!-- /.col -->

                
                <div class="col-md-6">
                  <!-- USERS LIST -->
                 
                  
                </div><!-- /.col -->
              </div><!-- /.row -->

  
            </div><!-- /.col -->

          </div><!-- /.row -->
        </section><!-- /.content -->
        <?php   }  ?>  
      </div><!-- /.content-wrapper -->
      
     

<?php
// If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

include_once 'php-includes/footer.inc.php';


?>