<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission...  (ON/OFF Invoices )         
$stmt_pid_1115 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1115" ); 
$stmt_pid_1115->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt_pid_1115->execute();

while ($stmt_pid_1115->fetch()){ 
    
}


 //Select the user and assign permission...  (ON/OFF ADD Invoice)        
$stmt_pid_1116 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1116" ); 
$stmt_pid_1116->bind_result($cp_users_id1130, $cp_users_firstname1130, $cp_users_lastname1130, $cp_userpermission_permission_id1130, $cp_userpermission_uid1130, $cp_userpermission_OnOff1116);
$stmt_pid_1116->execute();

while ($stmt_pid_1116->fetch()){ 
    
}




 //Select the user and assign permission...  (ON/OFF Delete Invoice)        
$stmt_pid_1117 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1117" ); 
$stmt_pid_1117->bind_result($cp_users_id1130, $cp_users_firstname1130, $cp_users_lastname1130, $cp_userpermission_permission_id1130, $cp_userpermission_uid1130, $cp_userpermission_OnOff1117);
$stmt_pid_1117->execute();

while ($stmt_pid_1117->fetch()){ 
    
     if ($cp_userpermission_OnOff1117 == 0){
     
        $style_pid_1117 = "display: none;";
     
 }
}


    // If the value is set form POST request to $ShowRecords1, that value will update on the database...
     if (isset($_POST["shorec"])){
   $ShowRecords1 = $_POST["shorec"];



     // Update the database from selected value
     $stmt2 = $db->prepare("UPDATE cp_settings SET showrecords=? WHERE `setting_id`=1 ");
     $stmt2->bind_param('i',$ShowRecords1);
     $stmt2->execute(); 
     //$stmt->close();

   }


 ?>


<?php

global $db;

                   
     //Select the database "setting" value and Set that value to $ShowRecords1 to genarate the records...
    $stmt1 = $db->prepare("SELECT showrecords FROM `cp_settings` WHERE `setting_id`=1 ");
    $stmt1->bind_result($ShowRecords1);
    $stmt1->execute();
    

    
    while ($stmt1->fetch()){ 
        
    }   
    
        
// This first query is just to get the total count of rows
$sql = "SELECT COUNT(id) FROM cp_invoice";
$query = mysqli_query($db, $sql);
$row = mysqli_fetch_row($query);

// Here we have the total row count
$rows = $row[0];

// This is the number of results we want displayed per page, $ShowRecords1 select form database "setting" table...
$page_rows = $ShowRecords1;

// This tells us the page number of our last page
$last = ceil($rows/$page_rows);

// This makes sure $last cannot be less than 1
if($last < 1){
	$last = 1;
}

// Establish the $pagenum variable (Page Numbers)
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['PageNo'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['PageNo']);
}

// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}

// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

// This is your query again , it is for grabbing just one page worth of rows by applying $limit
//$sql = "SELECT * FROM cp_invoice ORDER BY inv_invoice_date DESC $limit";
//$sql = "SELECT 
//           i.*, 
//           c.com_name AS customer_name
//        FROM 
//           cp_invoice i
//        LEFT JOIN 
//           cp_customers c ON i.inv_cos_id = c.id
//        ORDER BY 
//           i.inv_invoice_date DESC 
//        $limit";

$userId = $_SESSION['user_id'];

// Fetch user's permissions and rep_id
$userQuery = "SELECT rep_id, can_view_all_inv FROM cp_users WHERE id = $userId";
$userResult = mysqli_query($db, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$repId = $userData['rep_id'];
$canViewAll = $userData['can_view_all_inv'];

// Build the WHERE clause
$whereClause = "";
if ($canViewAll != 1) {
    $whereClause = "WHERE r.id = $repId";
}

// Main SQL query
$sql = "SELECT 
            i.*, 
            c.com_name AS customer_name,
            r.rep_name,
            u.firstname AS user_firstname,
            u.lastname AS user_lastname
        FROM 
            cp_invoice i
        LEFT JOIN 
            cp_customers c ON i.inv_cos_id = c.id
        LEFT JOIN 
            cp_rep r ON i.inv_rep_id = r.id
        LEFT JOIN 
            cp_users u ON u.rep_id = r.id
        $whereClause
        ORDER BY 
            i.inv_invoice_date DESC 
        $limit";


$query = mysqli_query($db, $sql);

// This shows the user what page they are on, and the total number of pages
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";


// Establish the $paginationCtrls variable
$paginationCtrls = '<ul class="pagination pagination-sm no-margin">';
 //If there is more than 1 page worth of results
if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li><a href="index.php?page=Invoice&PageNo=1">&laquo;&laquo;</a></li>'
                                 .'<li><a href="index.php?page=Invoice&PageNo='.$previous.'">&laquo;</a></li>';
                         
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-2; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="index.php?page=Invoice&PageNo='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
    
	// Render the target page number, but without it being a link
	$paginationCtrls .= '<li class="active" ><a href="#">'.$pagenum.'</a></li> ';
        
        
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="index.php?page=Invoice&PageNo='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+2){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= '<li><a href="index.php?page=Invoice&PageNo='.$next.'">&raquo;</a></li> '
                         .'<li><a href="index.php?page=Invoice&PageNo='.$last.'">&raquo;&raquo;</a></li>'
                         .'</ul>';
    }
}
    




 
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
            Invoices
            <small></small>
          </h1>        
        </section>

        
        <!-- Main content -->
        <section class="content">
              <div class="box box-primary">
                  
            <div class="box-header with-border">
              <h3 class="box-title">Invoices List</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
                  


        <div class="box-body">
             
             <!-- Paging Text -->   
             <div><?php echo $textline2; ?></div>   
            <form class="form-inline" method="POST" action="">  
                
                   <div class="form-group">
                     <input style="margin-bottom: 10px;" class="btn btn-sm btn-success" type="submit" value="Show" onclick="" name="submit" />                   
                      <div class="input-group">                     
                          <select style="margin-bottom: 10px;" name="shorec" class="form-control input-sm">
                          
                          <?php
                          
                            //Select the database setting value
                           $stmt = $db->prepare("SELECT showrecords FROM `cp_settings` WHERE `setting_id`=1 ");
                           $stmt->bind_result($ShowRecords1);
                           $stmt->execute();

                           
                           
                           while ($stmt->fetch()){ 
                               
                          
                          
                          ?>
                                <option><?php echo $ShowRecords1; ?></option> 
                        
                            <?php
                             }
                            ?>
                        
                        
                        <option>5</option>
                        <option>10</option>
                        <option>50</option>
                        <option>100</option>

                      </select>
                          

                      </div>
                       
                   </div>

                    
               </form> 
             
         <!-- Search Form -->       
 <?php
 if ($cp_userpermission_OnOff1116 == 0){
     
     $style1116 = "display: none;";
     
 }
 
 ?>
                <form style="margin-bottom: 10px;" role="form" method="get" action="" class="form-inline">
                    <input type="hidden" name="page" value="Invoice">
                    <input style="margin-top: 10px;" class="form-control" type="text" name="SearchKey" value="" placeholder="Invoice ID"/>
                    <input style="margin-top: 10px;" class="btn btn-primary btn-flat" type="submit" onclick="" value="Search">
                    <a style="margin-top: 10px;" href="index.php?page=Invoice&PageNo=1" class="btn btn-info btn-flat" >View All</a>
                    
                    <a style="margin-top: 10px;<?php echo $style1116; ?>" href="index.php?page=AddInvoice" class="btn btn-success btn-flat" >Add New Invoice</a>

                </form>
             


                     
 <?php
 if(!isset($_GET["SearchKey"])){
     

 ?>
             <form name="myform" action="" method="post">      
                        <div class="box-body table-responsive no-padding">                 
                    <table id="all_invoice_table" class="table table-hover table-bordered table-responsive">
                         
                         
                    <thead>
                      <tr>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Invoice Date</th>
                        <th>Delivery Date</th>
                        <th>Grand Total (Rs)</th>
                        <th>Action</th> 
                        
                       
                      </tr>
                    </thead>
                    <tbody>

                        <?php

                        $PNo = $_GET["PageNo"];  
                        
                            // Loop to generate database values to table...       
                           while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
                           {
                
                        ?>
                    
                        
                        <tr>

                        
                         <td><?php echo $row['inv_id']  ?></td>
                         <td><?php echo $row['customer_name']  ?></td>
                         <td><?php echo $row['inv_invoice_date']  ?></td>
                         <td><?php  echo $row['inv_delivery_date'] ?></td>
                         <td>
                             <?php  echo $row['inv_grand_total'] ?>
                                <?php if ($row['is_paid'] == 1) { ?>
                                        <small class="label pull-right bg-green">PAID</small>
                             <?php } ?>
                         </td>
                         <td >  
                                <a  title="Edit / View Invoice" href="index.php?page=ViewInvoice&InvID=<?php echo $row['inv_id'] ?>&PageNo=<?php echo $PNo; ?>" class="btn btn-warning btn-flat fa fa-pencil" > View Invoice</a>
                                <button type="button" style="<?php echo $style_pid_1117; ?>" class="btn btn-danger delete-invoice" data-invoiceid="<?php echo $row['inv_id'];  ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>                        
                         
                         </td>
                      </tr>
                      <?php } ?>
                    
                   </tbody>                
                  </table> 
                 </div>   
    </form> 
         
                        <div style="margin-top: 5px;" class="pull-right" id="pagination_controls"><?php echo $paginationCtrls; ?> </div> 
                  



 <?php

        } else {


           $SearchKey =  $_GET["SearchKey"]; 

           $sql_2 = "SELECT * FROM cp_invoice WHERE inv_id LIKE '%{$SearchKey}%'";
           $query_2 = mysqli_query($db, $sql_2);
                                     
                    
?>
  
        
         
 <!-- Search Result Table -->                                    
<form name="myform2" action="" method="post">      
 <div class="box-body table-responsive no-padding">   
    <table id="all_invoice_table" class="table table-hover table-bordered table-responsive">
                         
                         
                    <thead>
                      <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Delivery Date</th>
                        <th>Grand Total (Rs)</th>
                        <th>Action</th> 
                        
                        
                       
                      </tr>
                    </thead>
                    <tbody>
                        

                        <?php

                            // Loop to generate database values to table...       
                           while($row = mysqli_fetch_array($query_2, MYSQLI_ASSOC))
                           {
                 
                        ?>
                        <tr>
                        
                         <td><?php echo $row['inv_id']  ?></td>
                         <td><?php echo $row['inv_invoice_date']  ?></td>
                         <td><?php  echo $row['inv_delivery_date'] ?></td>
                         <td><?php  echo $row['inv_grand_total'] ?></td>
                         <td >  
                       
                                <a title="Edit / View Invoice" href="index.php?page=ViewInvoice&InvID=<?php echo $row['id'] ?>&SearchKey=<?php echo $_GET['SearchKey']; ?>" class="btn btn-warning btn-flat fa fa-pencil" > View Invoice</a>
                                <button type="button" style="<?php echo $style_pid_1117; ?>" class="btn btn-danger delete-invoice" data-invoiceid="<?php echo $row['inv_id'];  ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>   
                         </td>
                      </tr>
                      
                      
                  
                   <?php

                           }
                           
                   ?>

                     
                     

                    </tbody>       
                  </table>  
 </div>       
   </form>  
                                    
                                    
                                    
              <?php
              }
              ?> 
                                   
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
               </section>

       
        <?php   

           $db->close();
        
            }  
        
       
        
        ?>  
    
  </div><!-- /.col -->
  
<?php if (isset($_SESSION['alert'])): ?>
<script>
Swal.fire({
    icon: '<?= $_SESSION['alert']['type'] ?>',
    title: '<?= $_SESSION['alert']['message'] ?>',
    showConfirmButton: false,
    timer: 3000
});
</script>
<?php unset($_SESSION['alert']); endif; ?>

 <?php


   
// If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

 ?>