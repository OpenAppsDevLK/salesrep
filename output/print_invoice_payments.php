<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

include_once '../php-includes/connect.inc.php';

// Get Invoice ID from URL
if (!isset($_GET['InvID']) || empty($_GET['InvID'])) {
    die("Invoice ID is missing from the URL");
}

$inv_id = mysqli_real_escape_string($db, $_GET['InvID']);

// Fetch payments
$stmt_payments = $db->prepare("
    SELECT payment_id, pay_date, cash_amount, cheq_amount, cheq_date, cheq_detail, notes
    FROM cp_inv_payment
    WHERE p_inv_id = ?
    ORDER BY pay_date DESC
");
$stmt_payments->bind_param("s", $inv_id);
$stmt_payments->execute();
$result_payments = $stmt_payments->get_result();
$payments = $result_payments->fetch_all(MYSQLI_ASSOC);
$stmt_payments->close();

// Calculate totals
$total_cash = 0;
$total_cheque = 0;
$total_paid = 0;

foreach ($payments as $payment) {
    $total_cash += $payment['cash_amount'];
    $total_cheque += $payment['cheq_amount'];
}
$total_paid = $total_cash + $total_cheque;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Payments #<?= $inv_id ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .invoice-box { 
            max-width: 800px; 
            margin: auto; 
            padding: 30px; 
            border: 1px solid #eee; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); 
        }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .company-info { text-align: right; }
        h1 { margin: 0; font-size: 24px; }
        h2 { margin: 0 0 10px; font-size: 20px; }
        h3 { margin: 15px 0 5px; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table th { background: #f5f5f5; text-align: left; padding: 8px; }
        table td { padding: 8px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary-box { 
            display: flex; 
            justify-content: space-between; 
            margin: 15px 0; 
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        .total-section { 
            text-align: right; 
            margin-top: 20px; 
            border-top: 1px solid #eee; 
            padding-top: 10px; 
        }
        .total-row { font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; }
            table { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <!-- Payments Table -->
        <?php if (!empty($payments)): ?>
        <h3>PAYMENTS RECEIVED | INVOICE: <?= $inv_id ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Cash</th>
                    <th>Cheque</th>
                    <th>Cheque Date</th>
                    <th>Cheque Details</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?= htmlspecialchars($payment['pay_date']) ?></td>
                    <td class="text-right">Rs. <?= number_format($payment['cash_amount'], 2) ?></td>
                    <td class="text-right">Rs. <?= number_format($payment['cheq_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($payment['cheq_date']) ?></td>
                    <td><?= htmlspecialchars($payment['cheq_detail']) ?></td>
                    <td><?= htmlspecialchars($payment['notes']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="summary-box">
            <div>
                <p><strong>Cash Paid:</strong> Rs. <?= number_format($total_cash, 2) ?></p>
            </div>
            <div>
                <p><strong>Cheque Paid:</strong> Rs. <?= number_format($total_cheque, 2) ?></p>
            </div>
            <div>
                <p><strong>Total:</strong> Rs. <?= number_format($total_paid, 2) ?></p>
            </div>           
        </div>
        <?php else: ?>
            <p>No payments found for this invoice.</p>
        <?php endif; ?>

        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" class="btn btn-success">Print</button>
            <button onclick="window.close()" class="btn btn-default">Close</button>
        </div>
    </div>
</body>
</html>