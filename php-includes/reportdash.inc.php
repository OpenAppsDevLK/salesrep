<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

        
// Select the user and assign permission...          
$stmt1122 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1122" ); 
$stmt1122->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1122->execute();

while ($stmt1122->fetch()){ 
    
}



?>



<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
 <?php
    if ($cp_userpermission_OnOff == 0){
        $Message .= "<h1>Access Denied</h1>";
        echo $Message;
        
    } else {
            
            
?>            
          <h1>
            Reports Dashboard
            
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

<?php
// Get total students
$stmt = $db->prepare("SELECT COUNT(id) FROM cp_customers");
$stmt->bind_result($TotalCustomers);
$stmt->execute();

while ($stmt->fetch()){


}

?>
        
        <!-- Row 01 -->
        <section class="content">
          <!-- TOTAL STUDENTS -->
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Customers</span>
                  <span class="info-box-number"><?php echo $TotalCustomers; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
   
            
             <?php
               // Get total reps
               $stmt1 = $db->prepare("SELECT COUNT(id) FROM cp_rep");
               $stmt1->bind_result($TotalReps);
               $stmt1->execute();

               while ($stmt1->fetch()){
                 
                   
                }

            ?>
            
            <!-- TOTAL ALLOCATED -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Reps.</span>
                  <span class="info-box-number"><?php echo $TotalReps; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
             
            

            
            
            <div class="clearfix visible-sm-block"></div>
           <?php
           
               $stmt_root = $db->prepare("SELECT COUNT(id) FROM cp_root");
               $stmt_root->bind_result($TotalRoots);
               $stmt_root->execute();

               while ($stmt_root->fetch()){
                 
                   
                }

            ?>
            
            <!-- This Month Income -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-road"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Roots</span>
                  <span class="info-box-number"><?php echo $TotalRoots; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->


                            <?php
                                $Total_pay_amount1 = $db->prepare("SELECT (SUM(cash_amount)+SUM(cheq_amount)) FROM cp_inv_payment");
                                $Total_pay_amount1->bind_result($Total_Amount);
                                $Total_pay_amount1->execute();
                                while ($Total_pay_amount1->fetch()){

                                  //$Total_Amount =  $Total_Cash + $Total_Cheque;
                                  $Total_Amount = number_format($Total_Amount, 2, '.', ','); 
                                  //echo $Total_Amount;
                             }
                         ?>  
            
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-usd"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Paid Amount</span>
                  <span class="info-box-number">Rs. <?php echo $Total_Amount; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            
 
                            <?php
                                $Total_items = $db->prepare("SELECT COUNT(id) FROM cp_Items");
                                $Total_items->bind_result($TotalItems);
                                $Total_items->execute();
                                while ($Total_items->fetch()){

                                  
                             }
                         ?>  
            
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-briefcase"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Items</span>
                  <span class="info-box-number"><?php echo $TotalItems; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->   
            
            
                       <?php
                                $Total_Invoices = $db->prepare("SELECT COUNT(id) FROM cp_invoice");
                                $Total_Invoices->bind_result($TotalInvoices);
                                $Total_Invoices->execute();
                                while ($Total_Invoices->fetch()){

                                  
                             }
                         ?>  
            
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-list-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Invoices</span>
                  <span class="info-box-number"><?php echo $TotalInvoices; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->  
            
            
            
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
          

        
          

          <hr>
 
          

          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div style="background-color: #00c0ef;" class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Report: Total Customers</span>
                        <a href="output/customer_report.php" target="_blank" class="btn btn-primary btn-flat">Create</a>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div style="background-color: #00c0ef;" class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Report: Total Items</span>
                        <a href="output/item_report.php" target="_blank" class="btn btn-primary btn-flat">Create</a>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            
             <div class="col-md-6 col-sm-6 col-xs-12">
              <div style="background-color: #00c0ef;" class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Report: Total Reps</span>
                  <a href="output/rep_report.php" target="_blank" class="btn btn-primary btn-flat" >Create</a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            
            
             <div class="col-md-6 col-sm-6 col-xs-12">
              <div style="background-color: #00c0ef;" class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Report: Total Roots</span>
                  <a href="output/root_report.php" target="_blank" class="btn btn-primary btn-flat" >Create</a>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->            
            
            
            <?php

            // Query to fetch representatives
            $stmt5 = $db->prepare("SELECT id, rep_name FROM cp_rep");
            $stmt5->bind_result($rep_id, $rep_name);
            $stmt5->execute();
            ?>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div style="background-color: #00c0ef;" class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                    <div class="info-box-content">
                        <form target="_blank" action="output/rep_outstanding_report.php" method="get" class="form-inline">
                            <span class="info-box-text">Report: Rep-wise Outstanding</span>
                            <select style="margin-bottom: 5px;" name="RepID" class="form-control">
                                <?php while ($stmt5->fetch()) { ?>
                                    <option value="<?php echo $rep_id; ?>"><?php echo htmlspecialchars($rep_name); ?></option>
                                <?php } ?>
                            </select>
                            <input style="margin-bottom: 5px;" class="btn btn-primary btn-flat" type="submit" value="Create">
                        </form>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->

            <?php $stmt5->close(); ?>
            

            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div style="background-color: #00c0ef;" class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Report: Date Range Outstanding Report</span>
                        <form target="_blank" action="output/date_range_outstanding_report.php" method="get" class="form-inline">
                            <input style="margin-bottom: 5px;" class="form-control" type="date" name="date01" value="" placeholder="Start Date"/>
                            <input style="margin-bottom: 5px;" class="form-control" type="date" name="date02" value="" placeholder="End Date"/>
                            <input style="margin-bottom: 5px;" class="btn btn-primary btn-flat" type="submit" value="Create">
                        </form>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
                   
            
            
 </div><!-- /.row -->
 
 
 
          <hr>
          
            
        </section><!-- /.content -->
        
        <?php   
        
             }  
                              
                 
        ?>  
        

      </div><!-- /.content-wrapper -->
   
<?php
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}
