<?php

include_once '../php-includes/connect.inc.php';

// Sanitize and validate date inputs
$date01 = isset($_GET['date01']) && strtotime($_GET['date01']) ? date('Y-m-d', strtotime($_GET['date01'])) : '1970-01-01';
$date02 = isset($_GET['date02']) && strtotime($_GET['date02']) ? date('Y-m-d', strtotime($_GET['date02'])) : date('Y-m-d');

// Ensure date01 <= date02
if ($date01 > $date02) {
    $temp = $date01;
    $date01 = $date02;
    $date02 = $temp;
}

// Query to fetch outstanding invoices within date range
$sql = "SELECT 
            i.inv_id, 
            i.inv_invoice_date, 
            i.inv_grand_total, 
            i.is_paid, 
            c.com_name AS customer_name,
            GREATEST(i.inv_grand_total - COALESCE(SUM(p.cash_amount + p.cheq_amount), 0), 0) AS outstanding_amount
        FROM 
            cp_invoice i
        LEFT JOIN 
            cp_customers c ON i.inv_cos_id = c.id
        LEFT JOIN 
            cp_inv_payment p ON i.inv_id = p.p_inv_id
        WHERE 
            i.is_paid = 0 AND i.inv_invoice_date BETWEEN ? AND ?
        GROUP BY 
            i.inv_id
        ORDER BY 
            i.inv_invoice_date DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("ss", $date01, $date02);
$stmt->execute();
$result = $stmt->get_result();

// Query to count total outstanding invoices
$count_sql = "SELECT COUNT(inv_id) AS total_outstanding FROM cp_invoice WHERE is_paid = 0 AND inv_invoice_date BETWEEN ? AND ?";
$count_stmt = $db->prepare($count_sql);
$count_stmt->bind_param("ss", $date01, $date02);
$count_stmt->execute();
$count_stmt->bind_result($total_outstanding);
$count_stmt->fetch();
$count_stmt->close();

// Query to sum total outstanding amount
$amount_sql = "SELECT COALESCE(SUM(outstanding_amount), 0) AS total_amount
               FROM (
                   SELECT i.inv_id, GREATEST(i.inv_grand_total - COALESCE(SUM(p.cash_amount + p.cheq_amount), 0), 0) AS outstanding_amount
                   FROM cp_invoice i
                   LEFT JOIN cp_inv_payment p ON i.inv_id = p.p_inv_id
                   WHERE i.is_paid = 0 AND i.inv_invoice_date BETWEEN ? AND ?
                   GROUP BY i.inv_id
               ) AS subquery";
$amount_stmt = $db->prepare($amount_sql);
$amount_stmt->bind_param("ss", $date01, $date02);
$amount_stmt->execute();
$amount_stmt->bind_result($total_amount);
$amount_stmt->fetch();
$amount_stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Date Range Outstanding Invoices Report</title>
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
        <h2>Date Range Outstanding Invoices Report</h2>
        <h4>Date Range: <?php echo htmlspecialchars($date01); ?> to <?php echo htmlspecialchars($date02); ?></h4>
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
            <?php if ($result->num_rows > 0) { ?>
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
            <?php } else { ?>
                <tr>
                    <td colspan="6" class="text-center">No outstanding invoices found for the selected date range.</td>
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