<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];
        
    // Include database connection
    include_once '../php-includes/connect.inc.php'; 

    function add_inv_payment($db) {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_pay_submit'])) {
            try {
                // Validate and sanitize input data
                $p_inv_id = mysqli_real_escape_string($db, $_POST['txt_pay_inv_id']);
                $pay_date = mysqli_real_escape_string($db, $_POST['txt_pay_date']);
                $cash_amount = floatval($_POST['txt_pay_cash_amount']) ?: 0;
                $cheq_amount = floatval($_POST['txt_pay_chq_amount']) ?: 0;
                $cheq_date = !empty($_POST['txt_pay_chq_date']) ? mysqli_real_escape_string($db, $_POST['txt_pay_chq_date']) : null;
                $cheq_detail = mysqli_real_escape_string($db, $_POST['txt_pay_chq_no'] ?? '');
                $notes = mysqli_real_escape_string($db, $_POST['txt_pay_notes'] ?? '');

                // Validate required fields
                if (empty($p_inv_id)) {
                    throw new Exception("Invoice ID is required");
                }
                
                if (empty($pay_date)) {
                    throw new Exception("Payment date is required");
                }

                // Validate at least one amount is provided
                if ($cash_amount <= 0 && $cheq_amount <= 0) {
                    throw new Exception("Please enter either Cash Amount or Cheque Amount");
                }

                // If cheque amount is entered, require cheque details
                if ($cheq_amount > 0) {
                    if (empty($cheq_date)) {
                        throw new Exception("Cheque Date is required when entering Cheque Amount");
                    }
                    if (empty($cheq_detail)) {
                        throw new Exception("Cheque Details are required when entering Cheque Amount");
                    }
                }

                // Prepare and execute the insert statement
                $stmt = $db->prepare("
                    INSERT INTO cp_inv_payment (
                        p_inv_id,
                        pay_date,
                        cash_amount,
                        cheq_amount,
                        cheq_date,
                        cheq_detail,
                        notes
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $db->error);
                }
                
                $stmt->bind_param(
                    "ssddsss",
                    $p_inv_id,
                    $pay_date,
                    $cash_amount,
                    $cheq_amount,
                    $cheq_date,
                    $cheq_detail,
                    $notes
                );
                
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }
                
                $stmt->close();
                
                // Success message
                //Redirect to the page after inset 
                echo "<script>location='index.php?page=ViewInvoice&InvID=$p_inv_id'</script>";
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error adding payment: " . $e->getMessage();
                return false;
            }
        }
        return false;
    }
    
} else { 
    // If session isn't meet, user will redirect to login page
    header('Location: ../login.php');
    exit();
}
?>