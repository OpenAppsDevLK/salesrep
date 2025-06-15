<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission...          
$stmt1114 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1114" ); 
$stmt1114->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1114->execute();

while ($stmt1114->fetch()){ 
    
}


//linked with updatestudentdetils.fn.php
$Update_Customer = UpdateCustomerDetails();


?>

<!-- Content Wrapper. Contains page content -->
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
            Update Customer Details
            <small>You can update customer details.</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Customer Details</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             
           <!-- general form elements disabled -->

                  <form id="form_addstudent" role="form" action="<?php $Update_Customer;  ?>" method="post" enctype="multipart/form-data" >
 
                      <?php
 
                    if(isset($_GET['CustomerID'])){
                       $customerid = $_GET['CustomerID']; 
                       
                     $PNo = $_GET["PageNo"];  
                    

                       
                        $stmt = $db->prepare("SELECT id, com_id, com_name, com_tele, com_address, com_notes FROM `cp_customers` WHERE id= $customerid") ;
                        $stmt->bind_result($id, $com_id, $com_name, $com_tele, $com_address, $com_notes);
                        $stmt->execute();
                    
                        while ($stmt->fetch()){
                            
                            $id = htmlentities($id, ENT_QUOTES, "UTF-8");
                            $com_id = htmlentities($com_id, ENT_QUOTES, "UTF-8");
                            $com_name = htmlentities($com_name, ENT_QUOTES, "UTF-8");
                            $com_tele = htmlentities($com_tele, ENT_QUOTES, "UTF-8");
                            $com_address = htmlentities($com_address, ENT_QUOTES, "UTF-8");
                            $com_notes = htmlentities($com_notes, ENT_QUOTES, "UTF-8");
   
                            
                            
                        }
                    
                    
                    
                    }
                    
                    
                    ?>
                          
                      
                      <!-- text input -->

                    <input type="hidden" value="<?php echo $id; ?>" name="txt_com_AutoID" class="form-control" placeholder="AUTO" readonly>

                    <div class="form-group">
                      <label>Customer ID</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_com_id" value="<?php echo $com_id; ?>" class="form-control" readonly>
                       </div>
                    </div>


                     <div class="form-group">
                          <label>Customer Name</label>
                        <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                        <input type="text" value="<?php echo $com_name; ?>" name="txt_com_name" class="form-control">
                       </div>

                    </div>
                  
                    <div class="form-group">
                          <label>Contact No</label>
                        <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                        <input type="text" value="<?php echo $com_tele; ?>" name="txt_com_tele" class="form-control">
                       </div>

                    </div>
                      
                    <div class="form-group">
                      <label>Address</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                      <textarea class="form-control" name="txt_com_address" rows="3"><?php echo $com_address; ?></textarea>
                       </div>
                    </div>
                    
                    <div class="form-group">
                      <label>Notes</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                      <textarea class="form-control" name="txt_com_notes" rows="3"><?php echo $com_notes; ?></textarea>
                       </div>
                    </div>                    
              
              
                  
           <div class="box-footer">
              
               <?php
               
               if(isset($_GET["SearchKey"])){
                   $LINK = "index.php?page=Customers&SearchKey={$_GET['SearchKey']}";
                   $ButText = "Go Back to Search";
               }  else {
                   $LINK = "index.php?page=Customers&PageNo=$PNo";
                   $ButText = "View All";
               }
               
               ?>
                <div class= "col-lg-6 col-md-12 col-xs-1">
                    <input  style="margin-top: 5px;" class="btn  btn-success btn-lg" type="submit" name="btn_updatecompany" onclick="" value="Update Customer Details">
                <a style="margin-top: 5px;" href="<?php echo $LINK; ?>" class="btn  btn-primary"><?php echo $ButText; ?> </a>
                </div>
            
         
            </div><!-- /.box-footer-->   
                     
            </form>      
            
            

          </div><!-- /.box -->

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

      
      ?>