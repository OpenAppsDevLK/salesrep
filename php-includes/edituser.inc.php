<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission...          
$stmt1128 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1128" ); 
$stmt1128->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1128->execute();

while ($stmt1128->fetch()){ 
    
}

//linked with updateuser.fn.php
$UPDATEUSER = updateuser();

if (isset($_GET['UserID'])){
    $UserID = $_GET['UserID'];
    

    $PNo = $_GET['PageNo'];
    


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
            Edit User
            <small>You can Edit users details form here...</small>
          </h1>
        </section>

        <?php
        
        $stmt = $db->prepare("SELECT id, username, password, firstname, lastname FROM `cp_users` WHERE `id`= $UserID ");
        $stmt->bind_result($Uid, $username, $password, $firstname, $lastname);
        $stmt->execute();



        while ($stmt->fetch()){ 
            
        }        
        
        ?>
        
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Details</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

                 <button style="margin-top: 5px;" type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#<?php echo $_GET['UserID'] ?>"><span class="glyphicon glyphicon-remove"></span></button> 

                                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form id="form_addstudent" role="form" action="<?php $UPDATEUSER;  ?>" method="post" enctype="multipart/form-data" >
                    <!-- text input -->

                      <input type="hidden" name="txt_AU_AutoID" value="<?php echo $Uid;  ?>" class="form-control" placeholder="AUTO" readonly>

                    
                    <div class="form-group">
                      <label>User Name</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_AU_username" value="<?php echo $username;  ?>" class="form-control ">
                       </div>
                    </div>

                     <div class="form-group">
                          <label>Password</label>
                        <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                            <input type="password" name="txt_AU_pass"  class="form-control">
                       </div>

                    </div>
                    
                    <div class="form-group">
                      <label>First Name</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_AU_Fname" value="<?php echo $firstname;  ?>" class="form-control ">
                       </div>
                    </div>

                     <div class="form-group">
                          <label>Last Name</label>
                        <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>
                        <input type="text" name="txt_AU_LName" value="<?php echo $lastname;  ?>" class="form-control">
                       </div>

                    </div>
                    
             
           <div class="box-footer">
              
                <div class= "col-lg-6 col-md-12 col-xs-1">
                <input  style="margin-top: 5px;" class="btn  btn-success btn-lg" type="submit" onclick="" value="Edit User Details">
                <a style="margin-top: 5px;" href="index.php?page=ViewAllUsers&PageNo=<?php echo $PNo; ?>" class="btn  btn-danger">View All Users </a>
                </div>
            
 
<!-- Modal Window for Delete User-->
<div class="modal fade modal-danger" id="<?php echo $_GET['UserID'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <div class="modal-body">
          Do you want to delete this User... ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">No</button>
        <a  href="actions/deleteuser.php?UserID=<?php echo $_GET['UserID'] ?>" class='btn btn-success btn-flat'>Yes</a>
      </div>
    </div>
  </div>
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
 }
 
 ?>

<?php
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

?>
