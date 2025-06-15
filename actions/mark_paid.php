<?php
session_start();
require_once '../php-includes/connect.inc.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get invoice ID
$inv_id = isset($_GET['InvID']) ? (int)$_GET['InvID'] : 0;

if ($inv_id > 0) {
    try {
        // Update the is_paid status
        $stmt = $db->prepare("UPDATE cp_invoice SET is_paid = 1 WHERE inv_id = ?");
        $stmt->bind_param("i", $inv_id);
        $stmt->execute();
        
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Invoice marked as paid successfully'
        ];
    } catch (Exception $e) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

header("Location: ../index.php?page=ViewInvoice&InvID=$inv_id"); // Redirect back
exit();
?>