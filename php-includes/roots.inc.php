<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission...  (On/OFF Roots)         
$stmt_pid_1114 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1114" ); 
$stmt_pid_1114->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt_pid_1114->execute();

while ($stmt_pid_1114->fetch()){ 
    
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
$sql = "SELECT COUNT(id) FROM cp_root";
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
$sql = "SELECT * FROM cp_root ORDER BY root_name ASC $limit";

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
		$paginationCtrls .= '<li><a href="index.php?page=Roots&PageNo=1">&laquo;&laquo;</a></li>'
                                 .'<li><a href="index.php?page=Roots&PageNo='.$previous.'">&laquo;</a></li>';
                         
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-2; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="index.php?page=Roots&PageNo='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
    
	// Render the target page number, but without it being a link
	$paginationCtrls .= '<li class="active" ><a href="#">'.$pagenum.'</a></li> ';
        
        
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="index.php?page=Roots&PageNo='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+2){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= '<li><a href="index.php?page=Roots&PageNo='.$next.'">&raquo;</a></li> '
                         .'<li><a href="index.php?page=Roots&PageNo='.$last.'">&raquo;&raquo;</a></li>'
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
            Roots 
            <small></small>
          </h1>           
            
        </section>

        
        <!-- Main content -->
        <section class="content">
              <div class="box box-primary">
                  
            <div class="box-header with-border">
              <h3 class="box-title">Roots List</h3>
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
                <form style="margin-bottom: 10px;" role="form" method="get" action="" class="form-inline">
                    <input type="hidden" name="page" value="Roots">
                    <input style="margin-top: 10px;" class="form-control" type="text" name="SearchKey" value="" placeholder="Roots ID or Name"/>
                    <input style="margin-top: 10px;" class="btn btn-primary btn-flat" type="submit" onclick="" value="Search">
                    <a style="margin-top: 10px;" href="index.php?page=Roots&PageNo=1" class="btn btn-info btn-flat" >View All</a>
                 
                    <button style="margin-top: 10px;" type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#changeMsg">Add New Root</button>                

                </form>
             
<?php
//linked with add_root.fn.php
$ADDROOT = addroot();

?>
  <!-- Modal Window for Add Root -->
<div class="modal fade modal-success" id="changeMsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="form_addstudent" style="" role="form" action="<?php $ADDROOT;  ?>" method="post" >

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ADD ROOT</h4>
      </div>
      <div class="modal-body">
       

            
                  <div class="form-group">
                      <label>Root ID</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="number" name="txt_root_id" value="<?php echo(rand(1000,10000)); ?>" class="form-control ">
                       </div>
                    </div>   
            
                     <div class="form-group">
                      <label>Root Name</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <input type="text" name="txt_root_name" value="" class="form-control" required>
                       </div>
                    </div>  
           
          
                   <div class="form-group">
                      <label>Notes</label>
                       <div class="input-group">
                        <div class="input-group-addon">
                        <i class="glyphicon glyphicon-menu-right"></i>
                        </div>                       
                           <textarea class="form-control" name="txt_root_notes" rows="4"></textarea>
                       </div>
                    </div>             
            
       
          
      </div>
      <div class="modal-footer">
        <input  style="" class="btn  btn btn-outline btn-flat"  type="submit"  name="btn_root_submit" value="Add New Root">
      
      </div>
    </form>
    </div>
      
  </div>
</div>
                     
 <?php
 if(!isset($_GET["SearchKey"])){
     

 ?>
                    <form name="myform" action="" method="post">
                        <div class="box-body table-responsive no-padding">                 
                    <table id="vas_table" class="table table-hover table-bordered table-responsive">
                         
                         
                    <thead>
                      <tr>
                        <th style="width:15px;">Select</th> 
                        <th style="width:100px;">Root ID</th>
                        <th>Root Name</th>
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

                        
                         <td><input name="check_list[]" type="checkbox" style="width:15px; height: 15px; border-radius: 0px;" id="check_list" value="<?php echo $row['id'] ?>" /></td>
                         <td><?php echo $row['root_id']  ?></td>
                         <td><?php  echo $row['root_name'] ?></td>
                         <td >  

                                <a style="margin-top: 10px;" title="Update Dealer Details" href="index.php?page=UpdateRoot&RootID=<?php echo $row['id'] ?>&PageNo=<?php echo $PNo; ?>" class="btn btn-info btn-flat glyphicon glyphicon-pencil" ></a>

  
                         </td>
                      </tr>
                      <?php } ?>
                    
                   </tbody>
                     
                  </table> 
                 </div>   
    </form> 
         
                        <div style="margin-top: 5px;" class="pull-right" id="pagination_controls"><?php echo $paginationCtrls; ?> </div> 
                  
                     
                     
                        <button style="margin-top: 5px;" class="btn btn-primary" id="check-all">Check All</button>
                        <button style="margin-top: 5px;" class="btn btn-success" id="uncheck-all">Uncheck All</button>
                        <button style="margin-top: 5px;" id="swalt" class="btn btn-danger">Delete All</button>
                               
                                
                    
<SCRIPT LANGUAGE="JavaScript">
        function checkAll(form) {
            form.querySelectorAll('input[name="check_list[]"]').forEach(checkbox => checkbox.checked = true);
        }

        function unCheckAll(form) {
            form.querySelectorAll('input[name="check_list[]"]').forEach(checkbox => checkbox.checked = false);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.forms['myform'];
            if (!form) {
                console.error('Form "myform" not found.');
                return;
            }

            const checkAllBtn = document.querySelector('#check-all');
            const uncheckAllBtn = document.querySelector('#uncheck-all');
            const deleteBtn = document.querySelector('#swalt');

            if (checkAllBtn) {
                checkAllBtn.addEventListener('click', () => checkAll(form));
            }

            if (uncheckAllBtn) {
                uncheckAllBtn.addEventListener('click', () => unCheckAll(form));
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const checkedBoxes = form.querySelectorAll('input[name="check_list[]"]:checked');
                    if (checkedBoxes.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select at least one root to delete.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to delete the selected roots?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d9534f',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'No, Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.action = 'actions/delete_root.php?page=Customer&PageNo=<?php echo (int)$PNo; ?>';
                            form.submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Operation Terminated',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            }
        });


</script>



 <?php

                    } else {
                        

                       $SearchKey =  $_GET["SearchKey"]; 
                       
                       $sql_2 = "SELECT * FROM cp_root WHERE root_id LIKE '%{$SearchKey}%' OR root_name LIKE '%{$SearchKey}%'";
                       $query_2 = mysqli_query($db, $sql_2);
                  
?>
  
        
         
 <!-- Search Result Table -->                                    
<form name="myform_af_search" action="" method="post">      
 <div class="box-body table-responsive no-padding">   
    <table id="vas_table2" class="table table-hover table-bordered table-responsive">
                         
                         
                    <thead>
                      <tr>
                        <th style="width:15px;">Select</th> 
                        <th style="width:100px;">Root ID</th>
                        <th>Root Name</th>
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

                        <td><input name="check_list[]" type="checkbox" style="width:15px; height: 15px; border-radius: 0px;" id="check_list" value="<?php echo $row['id'] ?>" /></td>
                         <td><?php echo $row['root_id']  ?></td>
                         <td><?php  echo $row['root_name'] ?></td>
                         <td >  

                                <a style="margin-top: 10px;" title="Update Dealer Details" href="index.php?page=UpdateRoot&RootID=<?php echo $row['id'] ?>&PageNo=1&SearchKey=<?php echo $_GET["SearchKey"]; ?>" class="btn btn-info btn-flat glyphicon glyphicon-pencil" ></a>

  
                         </td>
                 </tr>
                      
                      
                  
                   <?php

                           }
                           
                   ?>

                     
                     

                    </tbody>       
                  </table>  
 </div>       
   </form>  

                        <button style="margin-top: 5px;" class="btn btn-primary" id="check-all">Check All</button>
                        <button style="margin-top: 5px;" class="btn btn-success" id="uncheck-all">Uncheck All</button>
                        <button style="margin-top: 5px;" id="swalt" class="btn btn-danger">Delete All</button>
                               
                                
                    
<SCRIPT LANGUAGE="JavaScript">
        function checkAll(form) {
            form.querySelectorAll('input[name="check_list[]"]').forEach(checkbox => checkbox.checked = true);
        }

        function unCheckAll(form) {
            form.querySelectorAll('input[name="check_list[]"]').forEach(checkbox => checkbox.checked = false);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.forms['myform_af_search'];
            if (!form) {
                console.error('Form "myform" not found.');
                return;
            }

            const checkAllBtn = document.querySelector('#check-all');
            const uncheckAllBtn = document.querySelector('#uncheck-all');
            const deleteBtn = document.querySelector('#swalt');

            if (checkAllBtn) {
                checkAllBtn.addEventListener('click', () => checkAll(form));
            }

            if (uncheckAllBtn) {
                uncheckAllBtn.addEventListener('click', () => unCheckAll(form));
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const checkedBoxes = form.querySelectorAll('input[name="check_list[]"]:checked');
                    if (checkedBoxes.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select at least one root to delete.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to delete the selected roots?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d9534f',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'No, Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.action = 'actions/delete_root.php?page=Customer&PageNo=<?php echo (int)$PNo; ?>';
                            form.submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Operation Terminated',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            }
        });


</script>                  
                                    
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
 <?php


   
// If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

 ?>