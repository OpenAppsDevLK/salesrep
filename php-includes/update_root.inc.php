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


//linked with update_root.fn.php
$UPDATEROOT = updaterootdetails();


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
            Update Root Details
            <small>You can update Root details form here...</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Root Details</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             
                  <form id="form_addstudent" role="form" action="<?php $UPDATEROOT;  ?>" method="post" enctype="multipart/form-data" >
 
                      <?php
 

                    if(isset($_GET['RootID'])){
                       $rootid = $_GET['RootID']; 
                       
                     $PNo = $_GET["PageNo"];  
                    

                       
                        $stmt = $db->prepare("SELECT id, root_id, root_name, root_notes FROM `cp_root` WHERE id= $rootid") ;
                        $stmt->bind_result($id, $root_id, $root_name, $root_notes);
                        $stmt->execute();
                    
                        while ($stmt->fetch()){
                            
                            $id = htmlentities($id, ENT_QUOTES, "UTF-8");
                            $root_id = htmlentities($root_id, ENT_QUOTES, "UTF-8");
                            $root_name = htmlentities($root_name, ENT_QUOTES, "UTF-8");
                            $root_notes = htmlentities($root_notes, ENT_QUOTES, "UTF-8");
                           
   
                            
                            
                        }
                    
                    
                    
                    }
                    
                    
                    ?>
                          
                      
                      <!-- text input -->

                  <input type="hidden" name="txt_root_AutoID" value="<?php echo $id;  ?>" class="form-control" placeholder="AUTO" readonly>

            
                  <div class="form-group">
                      <label>Root ID</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="number" name="txt_root_id" value="<?php echo $root_id; ?>" class="form-control " readonly>
                       </div>
                    </div>   
            
                     <div class="form-group">
                      <label>Root Name</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_root_name" value="<?php echo $root_name; ?>" class="form-control" required>
                       </div>
                    </div>  
           
          
                   <div class="form-group">
                      <label>Notes</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <textarea class="form-control" name="txt_root_notes" rows="4"><?php echo $root_notes; ?></textarea>
                       </div>
                    </div>             
               
              
              
                  
           <div class="box-footer">
              
               <?php
               
               if(isset($_GET["SearchKey"])){
                   $LINK = "index.php?page=Roots&SearchKey={$_GET['SearchKey']}";
                   $ButText = "Go Back to Search";
               }  else {
                   $LINK = "index.php?page=Roots&PageNo=$PNo";
                   $ButText = "View All";
               }
               
               ?>
                <div class= "col-lg-6 col-md-12 col-xs-1">
                    <input  style="margin-top: 5px;" class="btn  btn-success btn-lg" type="submit" name="btn_updateroot" onclick="" value="Update Root Details">
                <a style="margin-top: 5px;" href="<?php echo $LINK; ?>" class="btn  btn-primary"><?php echo $ButText; ?> </a>
                </div>
            
         
            </div><!-- /.box-footer-->   
                     
            </form>      
            </div><!-- /.box-body -->
            
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