<?php
session_start();
require_once '../php-includes/connect.inc.php';

// Check if user is logged in and has permission
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    die(json_encode(['error' => 'Unauthorized access']));
}

// Get invoice ID
$invoice_id = isset($_POST['invoice_id']) ? (int)$_POST['invoice_id'] : 0;

if ($invoice_id <= 0) {
    die(json_encode(['error' => 'Invalid invoice ID']));
}

try {
    // Begin transaction
    $db->begin_transaction();
    
    // 1. First delete invoice items
    $stmt = $db->prepare("DELETE FROM cp_invoice_items WHERE inv_id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    
    // 2. Delete payments
    $stmt = $db->prepare("DELETE FROM cp_inv_payment WHERE p_inv_id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    
    // 3. Delete return items
    $stmt = $db->prepare("DELETE FROM cp_return_items WHERE inv_id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    
    // 4. Finally delete the invoice
    $stmt = $db->prepare("DELETE FROM cp_invoice WHERE inv_id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    
    // Commit transaction
    $db->commit();
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback on error
    $db->rollback();
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}
?>