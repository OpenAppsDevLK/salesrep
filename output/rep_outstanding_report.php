<?php

include_once '../php-includes/connect.inc.php';

// Get rep_id from GET parameter
$rep_id = isset($_GET['RepID']) ? (int)$_GET['RepID'] : 0;

// Fetch representative's name for the report header
$stmt_rep = $db->prepare("SELECT rep_name FROM cp_rep WHERE id = ?");
$stmt_rep->bind_param("i", $rep_id);
$stmt_rep->execute();
$stmt_rep->bind_result($rep_name);
$rep_name = $stmt_rep->fetch() ? $rep_name : 'Unknown Representative';
$stmt_rep->close();

// Query to fetch outstanding invoices with outstanding amount
$sql = "SELECT 
            i.inv_id, 
            i.inv_invoice_date, 
            i.inv_grand_total, 
            i.is_paid, 
            c.com_name AS customer_name,
            (i.inv_grand_total - COALESCE(SUM(p.cash_amount + p.cheq_amount), 0)) AS outstanding_amount
        FROM 
            cp_invoice i
        LEFT JOIN 
            cp_customers c ON i.inv_cos_id = c.id
        LEFT JOIN 
            cp_inv_payment p ON i.inv_id = p.p_inv_id
        WHERE 
            i.is_paid = 0 AND i.inv_rep_id = ?
        GROUP BY 
            i.inv_id
        ORDER BY 
            i.inv_invoice_date DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $rep_id);
$stmt->execute();
$result = $stmt->get_result();

// Query to count total outstanding invoices
$count_sql = "SELECT COUNT(inv_id) AS total_outstanding FROM cp_invoice WHERE is_paid = 0 AND inv_rep_id = ?";
$count_stmt = $db->prepare($count_sql);
$count_stmt->bind_param("i", $rep_id);
$count_stmt->execute();
$count_stmt->bind_result($total_outstanding);
$count_stmt->fetch();
$count_stmt->close();

// Query to sum total outstanding amount
$amount_sql = "SELECT COALESCE(SUM(i.inv_grand_total - COALESCE((
                SELECT SUM(p.cash_amount + p.cheq_amount)
                FROM cp_inv_payment p
                WHERE p.p_inv_id = i.inv_id
            ), 0)), 0) AS total_amount
            FROM cp_invoice i
            WHERE i.is_paid = 0 AND i.inv_rep_id = ?";
$amount_stmt = $db->prepare($amount_sql);
$amount_stmt->bind_param("i", $rep_id);
$amount_stmt->execute();
$amount_stmt->bind_result($total_amount);
$amount_stmt->fetch();
$amount_stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rep-wise Outstanding Invoices Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            margin: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-button {
            margin-bottom: 20px;
        }
        .total-outstanding {
            margin-top: 10px;
            font-weight: bold;
        }
        @media print {
            .print-button {
                display: none;
            }
            .report-header {
                font-size: 16px;
            }
            .table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h2>Rep-wise Outstanding Invoices Report</h2>
        <h4>Representative: <?php echo htmlspecialchars($rep_name); ?></h4>
        <p>Generated on <?php echo date('F j, Y'); ?></p>
    </div>

    <button onclick="window.print()" class="btn btn-primary print-button">Print Report</button>

    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Customer</th>
                <th>Invoice Date</th>
                <th>Grand Total (Rs)</th>
                <th>Outstanding Amount (Rs)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['inv_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name'] ?: '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['inv_invoice_date']); ?></td>
                    <td><?php echo number_format($row['inv_grand_total'], 2); ?></td>
                    <td><?php echo number_format($row['outstanding_amount'], 2); ?></td>
                    <td><?php echo $row['is_paid'] == 0 ? 'Not Paid' : 'Paid'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total-outstanding">
        Total Outstanding Invoices: <?php echo $total_outstanding; ?><br>
        Total Outstanding Amount: Rs <?php echo number_format($total_amount, 2); ?>
    </div>

    <?php
    $stmt->close();
    mysqli_close($db);
    ?>
</body>
</html>