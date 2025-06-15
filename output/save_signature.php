<?php
session_start();
include_once '../php-includes/connect.inc.php';

if (isset($_POST['inv_id']) && isset($_POST['signature'])) {
    $inv_id = mysqli_real_escape_string($db, $_POST['inv_id']);
    $signature = mysqli_real_escape_string($db, $_POST['signature']);
    
    $stmt = $db->prepare("UPDATE cp_invoice SET customer_signature = ? WHERE inv_id = ?");
    $stmt->bind_param("ss", $signature, $inv_id);
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['customerSignature'] = $signature;
    echo 'Signature saved';
} else {
    echo 'Invalid request';
}
?>