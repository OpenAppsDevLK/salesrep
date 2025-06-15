<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission...          
//$stmt1114 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1114" ); 
//$stmt1114->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
//$stmt1114->execute();
//
//while ($stmt1114->fetch()){ 
//    
//}


//linked with update_item.fn.php
$UpdateItem = UpdateItemDetails();


?>

<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            
<?php
//    if ($cp_userpermission_OnOff == 1){
//        $Message .= "<h1>Access Denied</h1>";       
//        echo $Message;
//        
//    } else {                  
?>
            
          <h1>
            Edit Item Details
            <small>You can update item details...</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Item Details</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             
           <!-- general form elements disabled -->
                  <form id="form_addstudent" role="form" action="" method="post" enctype="multipart/form-data" >
 
                      <?php
 
                    if(isset($_GET['item_ID'])){
                       $ItemId = $_GET['item_ID']; 
                       
                     $PNo = $_GET["PageNo"];  
                    

                       
                        $stmt = $db->prepare("SELECT * FROM `cp_Items` WHERE id= $ItemId") ;
                        $stmt->bind_result($id, $item_code, $item_name, $item_note, $cost_price, $sales_price);
                        $stmt->execute();
                    
                        while ($stmt->fetch()){
                            
                            $id = htmlentities($id, ENT_QUOTES, "UTF-8");
                            $item_code = htmlentities($item_code, ENT_QUOTES, "UTF-8");
                            $item_name = htmlentities($item_name, ENT_QUOTES, "UTF-8");
                            $item_note = htmlentities($item_note, ENT_QUOTES, "UTF-8");
                            $cost_price = htmlentities($cost_price, ENT_QUOTES, "UTF-8");
                            $sales_price = htmlentities($sales_price, ENT_QUOTES, "UTF-8");
                            
   
                            
                            
                        }
                    
                    
                    
                    }
                    
                    
                    ?>
                          
                      
                      <!-- text input -->
                  <div class="form-group">
                      
                     <input type="hidden" name="txt_item_ID" value="<?php echo $id; ?>" class="form-control" placeholder="AUTO" readonly> 
            
                  <div class="form-group">
                      <label>Item Code</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_item_code" value="<?php echo $item_code; ?>" class="form-control ">
                       </div>
                    </div>   
            
                     <div class="form-group">
                      <label>Item Name</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_item_name" value="<?php echo $item_name; ?>" class="form-control" required>
                       </div>
                    </div>  
            
                   <div class="form-group">
                      <label>Notes</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <textarea class="form-control" name="txt_item_notes" rows="4"><?php echo $item_note; ?></textarea>
                       </div>
                    </div>  
          
                      <div class="form-group">
                      <label>Cost Price</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_cost_price" value="<?php echo $cost_price; ?>" class="form-control ">
                       </div>
                    </div>  

                   <div class="form-group">
                      <label>Sales Price</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_sales_price" value="<?php echo $sales_price; ?>" class="form-control ">
                       </div>
                    </div>   
           <div class="box-footer">
              
                <div class= "col-lg-6 col-md-12 col-xs-1">
                    <input  style="margin-top: 5px;" class="btn  btn-success btn-lg" type="submit" name="btn_UpdateItem">
                <a style="margin-top: 5px;" href="index.php?page=Items&PageNo=1" class="btn  btn-primary">View All</a>
                </div>
            
         
            </div><!-- /.box-footer-->   
                     
            </form>      
            </div><!-- /.box-body -->

        </section><!-- /.content -->
         <?php   
         
         //      }  
         ?> 
      </div><!-- /.content-wrapper -->

       <?php
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

      
      ?>