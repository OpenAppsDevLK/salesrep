<?php

// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SalesRep</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    
     <link rel="stylesheet" href="css/styles.css">
     
    
<!-- Sweet Alert Class-->
<script src="plugins/sweetalert/sweetalert-dev.js"></script>
<link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">

<!-- SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!-- Jq Calx plugin, this is for calulate from input values, call in additem.inc.php (name="txt-br-bundle-price") (data-cell) (data-format)-->
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="plugins/calx/jquery-calx-2.2.3.min.js"></script>

    <!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <!-- Invoice and Return Table Css page=AddInvoice -->
<link rel="stylesheet" href="dist/css/inv_reitem_table.css">

<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
   
<!-- Go back of a URL -->
<script>
function goBack() {
    window.history.back();
}
</script>

     <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>  
    

<!-- This is for html 5 date from for firefox and other web browsers -->
<!-- cdn for modernizr, if you haven't included it already -->
<script src="https://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="https://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script> 


<style>


/* Container for summary section */
.summary-section {
    background-color: #f1f5f9; /* Light blue-gray background */
    border: 1px solid #d1d9e6; /* Slightly darker border */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    padding: 20px; /* Comfortable padding */
    margin: 20px 0 20px 20px; /* Top, bottom, and left margin for desktop */
    max-width: 600px; /* Limit width */
}

/* Styling for h4 elements */
.summary-section h4 {
    font-size: 16px; /* Clear, readable font size */
    font-weight: 500; /* Medium weight */
    color: #333333; /* Dark gray text */
    margin: 10px 0; /* Vertical spacing */
    padding: 10px 15px; /* Padding for each item */
    border-left: 4px solid #3498db; /* Blue accent */
    background-color: #ffffff; /* White background for items */
    border-radius: 4px; /* Subtle rounded corners */
    display: flex; /* Flexbox for alignment */
    justify-content: space-between; /* Space out label and value */
    align-items: center; /* Vertically center */
    transition: background-color 0.3s ease; /* Smooth hover */
}

/* Hover effect for h4 elements */
.summary-section h4:hover {
    background-color: #e8f1fa; /* Light blue hover */
}

/* Styling for the value part */
.summary-section h4 span.summary-value {
    font-weight: 700; /* Bold for emphasis */
    color: #2c3e50; /* Darker shade for values */
}

/* Specific styling for monetary values */
#gross_total, #return_amount, #total_amount {
    font-weight: 600; /* Bolder for monetary fields */
}

/* Highlight Grand Total */
#total_amount {
    background-color: #e8f1fa; /* Light blue background */
    border-left-color: #e74c3c; /* Red accent */
    font-size: 18px; /* Larger font */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .summary-section {
        max-width: 100%; /* Full width on mobile */
        padding: 15px; /* Less padding */
        margin: 20px 10px; /* Smaller left/right margins */
    }
    .summary-section h4 {
        font-size: 14px; /* Smaller font */
        padding: 8px 10px; /* Adjust padding */
    }
    #total_amount {
        font-size: 16px; /* Smaller Grand Total */
    }
}


</style>


    <!-- Load Signature Pad from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        /* Ensure modal and canvas have proper dimensions */
        .signature-container {
            width: 100%;
            height: 200px;
            margin-bottom: 10px;
        }
        #signature-pad {
            width: 100%;
            height: 100%;
            border: 1px solid #ddd;
            background-color: white;
        }
        /* Make modal wider for better signature space */
        @media (min-width: 768px) {
            .modal-dialog {
                width: 600px;
            }
        }
    </style>  
    
    
    
  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

<!-- Logo -->
<a href="dash.php" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini">SR</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>SalesRep</b></span>
</a>

<?php

    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}
     
?>        