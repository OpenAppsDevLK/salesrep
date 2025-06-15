<?php

session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

//// Select the user and assign permission...
$stmt1125 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1125" ); 
$stmt1125->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1125->execute();

while ($stmt1125->fetch()){ 
    
}


$PNo = $_GET['PageNo'];
$UserName = $_GET['UserName'];


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
            Assign Permissions
            <small>You can Assign Permissions to users...</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Assign Permissions to <b><?php echo $_GET['UserName']; ?></b></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
             
           <!-- general form elements disabled -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Permissions</h3>
                </div><!-- /.box-header -->
                
                  <form id="form_addstudent" role="form" action="" method="post" enctype="multipart/form-data" >

  <?php
                    $TabNo = $_GET['tab'];
                    //Tab will change accouring to URL request....
                    if ($TabNo == 1){
                        $aciveTab1 = "active";
                        $TabID = "tab_1";
                    } else {
                        $aciveTab1 = "";
                        $TabID = "tab_1";  
                    }
                    
                   
                    if ($TabNo == 2){
                        $aciveTab2 = "active";
                        $TabID2 = "tab_2";
                    } else {
                        
                        $aciveTab2 = "";
                        $TabID2 = "tab_2";
                    }
                    
                    if ($TabNo == 3){
                        $aciveTab3 = "active";
                        $TabID3 = "tab_3";
                    } else {
                        
                        $aciveTab3 = "";
                        $TabID3 = "tab_3";
                    }
                    
                    if ($TabNo == 4){
                        $aciveTab4 = "active";
                        $TabID4 = "tab_4";
                    } else {
                        
                        $aciveTab4 = "";
                        $TabID4 = "tab_4";
                    }
                    
                    
                    if ($TabNo == 5){
                        $aciveTab5 = "active";
                        $TabID5 = "tab_5";
                    } else {
                        
                        $aciveTab5 = "";
                        $TabID5 = "tab_5";
                    }
                    
                    
                    
 ?>
                      
<div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="<?php echo $aciveTab1; ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Assets</a></li>
                  <li class="<?php echo $aciveTab2; ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Invoice</a></li>
                  <li class="<?php echo $aciveTab3; ?>"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Reports &AMP; Dash</a></li>
                  <li class="<?php echo $aciveTab4; ?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Users</a></li>
                  <li class="<?php echo $aciveTab5; ?>"><a href="#tab_5" data-toggle="tab" aria-expanded="false">Tools</a></li>
                </ul>
                <div class="tab-content">

                    
                    
<div class="tab-pane <?php echo $aciveTab1; ?>" id="<?php echo $TabID; ?>">
                    
 <!-- Start: Assign Permissions: PM 1111  (On/OFF Customers) -->
 <?php
 
    $UserID = $_GET['UserID'];
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1111 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1111 ");
    $stmt_pid_1111->bind_result($On_OFF);
    $stmt_pid_1111->execute();
   
    while ($stmt_pid_1111->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>
 
<dl class="dl-horizontal">
  <dt>Customers</dt>
  <dd>
      
  <a href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1111&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=1" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
  <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1111&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=1" class="btn btn-success btn-flat" >OFF</a>       
 
  </dd>
</dl>


<!-- END: Assign Permissions: PM 1111 -->

         
<!-- Start: Assign Permissions: PM 1112 (On/OFF Items) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1112 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1112 ");
    $stmt_pid_1112->bind_result($On_OFF);
    $stmt_pid_1112->execute();
   
    while ($stmt_pid_1112->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Items</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1112&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=1" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1112&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=1" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1112 -->

 

<!-- Start: Assign Permissions: PM 1113 (ON/OFF Rep ) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1113 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1113 ");
    $stmt_pid_1113->bind_result($On_OFF);
    $stmt_pid_1113->execute();
   
    while ($stmt_pid_1113->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Rep</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1113&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=1" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1113&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=1" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1113 -->

<!-- Start: Assign Permissions: PM 1114 (On/OFF Roots)-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1114 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1114 ");
    $stmt_pid_1114->bind_result($On_OFF);
    $stmt_pid_1114->execute();
   
    while ($stmt_pid_1114->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Roots</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1114&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=1" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1114&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=1" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1114 -->



</div><!-- /.tab-pane1 -->
                         
                                   
<div class="tab-pane <?php echo $aciveTab2; ?>" id="<?php echo $TabID2; ?>">

<!-- Start: Assign Permissions: PM 1115 (ON/OFF Invoices )-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1115 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1115 ");
    $stmt_pid_1115->bind_result($On_OFF);
    $stmt_pid_1115->execute();
   
    while ($stmt_pid_1115->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Invoices</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1115&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1115&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1115 -->

<!-- Start: Assign Permissions: PM 1116 (ON/OFF ADD Invoice)-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1116 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1116 ");
    $stmt_pid_1116->bind_result($On_OFF);
    $stmt_pid_1116->execute();
   
    while ($stmt_pid_1116->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
    <dt>Add Invoice</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1116&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1116&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1116 -->

<!-- Start: Assign Permissions: PM 1130 (ON/OFF Mark as Paid)-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1130 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1130 ");
    $stmt_pid_1130->bind_result($On_OFF);
    $stmt_pid_1130->execute();
   
    while ($stmt_pid_1130->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>"Mark As paid" Button</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1130&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1130&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1130 -->
    
    
<!-- Start: Assign Permissions: PM 1117 (ON/OFF Delete Invoice)-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1117 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1117 ");
    $stmt_pid_1117->bind_result($On_OFF);
    $stmt_pid_1117->execute();
   
    while ($stmt_pid_1117->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>
 
<dl class="dl-horizontal">
  <dt>Delete Invoice</dt>
  <dd>
      
  <a href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1117&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
  <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1117&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       
 
  </dd>
</dl>


<!-- END: Assign Permissions: PM 1117 -->

         
<!-- Start: Assign Permissions: PM 1118 (ON/OFF Add Payment) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1118 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1118 ");
    $stmt_pid_1118->bind_result($On_OFF);
    $stmt_pid_1118->execute();
   
    while ($stmt_pid_1118->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Add Payment</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1118&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1118&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1118 -->

 

<!-- Start: Assign Permissions: PM 1119 (ON/OFF Add Customer Signature)-->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt_pid_1119 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1119 ");
    $stmt_pid_1119->bind_result($On_OFF);
    $stmt_pid_1119->execute();
   
    while ($stmt_pid_1119->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Add Customer Signature</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1119&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=2" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1119&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1119 -->

<!-- Start: Assign Permissions: PM 1120 (ON/OFF Add Payments)-->
 <?php
    //This will select the settings value with database (1 or 0) under the setting_id                               
//    $stmt9 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1120 ");
//    $stmt9->bind_result($On_OFF);
//    $stmt9->execute();
//   
//    while ($stmt9->fetch()){
//        
//
//     }
//    
//   
//    
//             if($On_OFF =='1') {
//            $btn_colour = "btn-danger";
//        } else {
//            
//            $btn_colour = "btn-success";
//        }
 
 ?>

<!--<dl class="dl-horizontal">
 <dt>View Invoice >> <br> Add Payment</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php //echo $UserID; ?>&UserName=<?php //echo $UserName; ?>&PMID=1120&ONOFF=1&PageNo=<?php //echo $PNo; ?>&tab=2" class="btn <?php //echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php //echo $UserID; ?>&UserName=<?php //echo $UserName; ?>&PMID=1120&ONOFF=0&PageNo=<?php //echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>-->


<!-- END: Assign Permissions: PM 1120 -->

<!-- Start: Assign Permissions: PM 1129 (ON/OFF Delete Paymens and CNotes)-->
 <?php
     //This will select the settings value with database (1 or 0) under the setting_id                               
//    $stmt18 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1129 ");
//    $stmt18->bind_result($On_OFF);
//    $stmt18->execute();
//   
//    while ($stmt18->fetch()){
//        
//
//     }
//    
//   
//    
//             if($On_OFF =='1') {
//            $btn_colour = "btn-danger";
//        } else {
//            
//            $btn_colour = "btn-success";
//        }
 
 ?>
<!--
<dl class="dl-horizontal">
  <dt>Delete Credit Note and <br> Payments</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php //echo $UserID; ?>&UserName=<?php //echo $UserName; ?>&PMID=1129&ONOFF=1&PageNo=<?php //echo $PNo; ?>&tab=2" class="btn <?php //echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php //echo $UserID; ?>&UserName=<?php //echo $UserName; ?>&PMID=1129&ONOFF=0&PageNo=<?php //echo $PNo; ?>&tab=2" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>-->


<!-- END: Assign Permissions: PM 1129 -->

</div><!-- /.tab-pane2 -->
                             
                  
<div class="tab-pane <?php echo $aciveTab3; ?>" id="<?php echo $TabID3; ?>">

<!-- Start: Assign Permissions: PM 1121  (ON/OFF Main Dashboard) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt10 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1121 ");
    $stmt10->bind_result($On_OFF);
    $stmt10->execute();
   
    while ($stmt10->fetch()){
        

     }
    
   
    
        if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>
 
<dl class="dl-horizontal">
  <dt>Main Dashboard</dt>
  <dd>
      
  <a href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1121&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=3" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
  <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1121&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=3" class="btn btn-success btn-flat" >OFF</a>       
 
  </dd>
</dl>


<!-- END: Assign Permissions: PM 1121 -->

         
<!-- Start: Assign Permissions: PM 1122 (ON/OFF Reports Dashboard) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt11 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1122 ");
    $stmt11->bind_result($On_OFF);
    $stmt11->execute();
   
    while ($stmt11->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Reports Dashboard</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1122&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=3" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1122&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=3" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1122 -->

                  </div><!-- /.tab-pane3 -->
                  
                  
<div class="tab-pane <?php echo $aciveTab4; ?>" id="<?php echo $TabID4; ?>">
  
<!-- Start: Assign Permissions: PM 1123  (ON/OFF Add User) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt12 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1123 ");
    $stmt12->bind_result($On_OFF);
    $stmt12->execute();
   
    while ($stmt12->fetch()){
        

     }
    
   
    
        if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>
 
<dl class="dl-horizontal">
  <dt>Add User</dt>
  <dd>
      
  <a href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1123&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=4" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
  <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1123&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=4" class="btn btn-success btn-flat" >OFF</a>       
 
  </dd>
</dl>


<!-- END: Assign Permissions: PM 1123 -->

         
<!-- Start: Assign Permissions: PM 1124 (ON/OFF View All Users)  -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt13 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1124 ");
    $stmt13->bind_result($On_OFF);
    $stmt13->execute();
   
    while ($stmt13->fetch()){
        

     }
    
   
    
             if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>View All Users</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1124&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=4" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1124&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=4" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1124 -->

<!-- Start: Assign Permissions: PM 1125 (ON/OFF Assign Permission) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt14 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1125 ");
    $stmt14->bind_result($On_OFF);
    $stmt14->execute();
   
    while ($stmt14->fetch()){
        

     }
    
   
    
        if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Assign Permission</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1125&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=4" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1125&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=4" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1125 -->

<!-- Start: Assign Permissions: PM 1128 (ON/OFF Edit User) -->
 <?php
 
   
    
 
     //This will select the settings value with database (1 or 0) under the setting_id                               
    $stmt17 = $db->prepare("SELECT  OnOff FROM `cp_userpermission` WHERE `uid`= $UserID AND `permission_id` = 1128 ");
    $stmt17->bind_result($On_OFF);
    $stmt17->execute();
   
    while ($stmt17->fetch()){
        

     }
    
   
    
        if($On_OFF =='1') {
            $btn_colour = "btn-danger";
        } else {
            
            $btn_colour = "btn-success";
        }
 
 ?>

<dl class="dl-horizontal">
  <dt>Edit User</dt>
  <dd>
      
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1128&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=4" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1128&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=4" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>


<!-- END: Assign Permissions: PM 1128 -->



                  </div><!-- /.tab-pane4 -->
                  

<div class="tab-pane <?php echo $aciveTab5; ?>" id="<?php echo $TabID5; ?>">
    
<!-- Start: Assign Permissions: PM 1126  -->
 
<dl class="dl-horizontal">
    <dt style="display: none;">Announcements</dt>
  <dd>
      
  <a style="display: none;" href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1126&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=5" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
  <a style="display: none;"  href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1126&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=5" class="btn btn-success btn-flat" >OFF</a>       
 
  </dd>
</dl>

<!-- END: Assign Permissions: PM 1126 -->

         


<!-- Start: Assign Permissions: PM 1131 -->

<dl class="dl-horizontal">
  <dt style="display: none;">Institute</dt>
  <dd>
      
         <a  style="display: none;" href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1131&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=5" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  style="display: none;" href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1131&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=5" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>

<!-- END: Assign Permissions: PM 1131 -->


<!-- Start: Assign Permissions: PM 1132 -->
 
<dl class="dl-horizontal">
  <dt style="display: none;">Send SMS</dt>
  <dd>
      
         <a  style="display: none;" href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1132&ONOFF=1&PageNo=<?php echo $PNo; ?>&tab=5" class="btn <?php echo $btn_colour; ?> btn-flat" >ON</a>
         <a  style="display: none;" href="actions/assignpermission.php?page=AssignPermissions&UserID=<?php echo $UserID; ?>&UserName=<?php echo $UserName; ?>&PMID=1132&ONOFF=0&PageNo=<?php echo $PNo; ?>&tab=5" class="btn btn-success btn-flat" >OFF</a>       

  </dd>
</dl>

<!-- END: Assign Permissions: PM 1132 -->


                  </div><!-- /.tab-pane5 -->
                  
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div>
                      
                      





            <div class="box-footer">
              
                <div class= "col-lg-6 col-md-12 col-xs-1">
                <a style="margin-top: 5px;" href="index.php?page=ViewAllUsers&PageNo=<?php echo $PNo; ?>" class="btn  btn-danger">View All Users </a>
                
                </div>                 
                   
                     
            </form>      
            </div><!-- /.box-body -->
            

          <!-- /.box -->

        </section><!-- /.content -->
        <?php   
        
        }  
            
        ?>  
      </div><!-- /.content-wrapper -->

 <?php
 } else { 
    header('Location: login.php');
}

 
 ?>