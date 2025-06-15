<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];




//includes Files
include_once 'php-includes/connect.inc.php';
include_once 'php-includes/header.inc.php';
include_once 'php-includes/topnav.inc.php';
include_once 'php-includes/get-var.inc.php';
include_once 'php-includes/sidebarleft.inc.php'; 



// Function Files
include_once 'fun/update_customer.fn.php';
include_once 'fun/add_coustomer.fn.php';
include_once 'fun/add_rep.fn.php';
include_once 'fun/update_rep.fn.php';
include_once 'fun/add_root.fn.php';
include_once 'fun/update_root.fn.php';
include_once 'fun/add_inv.fn.php';
include_once 'fun/update_invoice.fn.php';
include_once 'fun/add_cdt_note.fn.php';
include_once 'fun/add_inv_payment.fn.php';
include_once 'fun/adduser.fn.php';
include_once 'fun/updateuser.fn.php';
include_once 'fun/add_item.fn.php';
include_once 'fun/update_item.fn.php';




if ($page == "UpdateCustomer"){
     require_once 'php-includes/update_customer.inc.php'; 
}  else {
    if ($page == "Customers"){
     require_once 'php-includes/customers.inc.php'; 
} else {
     if ($page == "Rep"){
     require_once 'php-includes/rep.inc.php'; 
} else {
     if ($page == "UpdateRep"){
     require_once 'php-includes/update_rep.inc.php'; 
} else {
     if ($page == "Roots"){
     require_once 'php-includes/roots.inc.php';
} else {
     if ($page == "UpdateRoot"){
     require_once 'php-includes/update_root.inc.php';
} else {
     if ($page == "Invoice"){
     require_once 'php-includes/invoice.inc.php';    
} else {
     if ($page == "AddInvoice"){
     require_once 'php-includes/addinvoice.inc.php';  

} else {
     if ($page == "ViewInvoice"){
     require_once 'php-includes/view_invoice.inc.php';
     
} else {
     if ($page == "EditSubject"){
     require_once 'php-includes/editsubject.inc.php';    
} else {
       if ($page == "Reports"){
     require_once 'php-includes/reportdash.inc.php';    
} else {
       if ($page == "AddUser"){
     require_once 'php-includes/adduser.inc.php';  
} else {
       if ($page == "ViewAllUsers"){
     require_once 'php-includes/viewallusers.inc.php'; 
     
} else {
       if ($page == "EditUser"){
     require_once 'php-includes/edituser.inc.php'; 
} else {
       if ($page == "AssignPermissions"){
     require_once 'php-includes/assignpermissions.inc.php';     
} else {
       if ($page == "AddAnnouncement"){
     require_once 'php-includes/announcement.inc.php'; 
} else {
    if ($page == "BConverter"){
     require_once 'php-includes/bconverter.inc.php'; 
} else {
     if ($page == "OldStudents"){
     require_once 'php-includes/oldstudents.inc.php'; 
} else {
      if ($page == "Institutes"){
     require_once 'php-includes/institue.inc.php'; 
} else {
    if ($page == "SendSMS"){
     require_once 'php-includes/sendsms.inc.php';
} else {
     if ($page == "AddExamMarks"){
     require_once 'php-includes/addexammarks.inc.php';
} else {
     if ($page == "ViewExamMarks"){
     require_once 'php-includes/viewexammarks.inc.php';
} else {
      if ($page == "AddExam"){
     require_once 'php-includes/addexam.inc.php'; 
} else {
      if ($page == "AddAbsents"){
     require_once 'php-includes/AddAbsents.inc.php';    
}  else {
       if ($page == "StuVsPay"){
     require_once 'php-includes/stuvspay.inc.php'; 
} else {
        if ($page == "StuVsAtten"){
     require_once 'php-includes/stuvsatten.inc.php'; 
} else {
    if ($page == "Items"){
     require_once 'php-includes/items.inc.php'; 
} else {
   if ($page == "EditItem"){
     require_once 'php-includes/edititem.inc.php';     
}   
}
}     
}
}
}     
}
}
}     
}     
}    
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}    




// If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}


?>





<?php

include_once 'php-includes/footer.inc.php';

?>