<?php

include_once '../php-includes/connect.inc.php';

// Query to fetch all customers
$sql = "SELECT com_id, com_name, com_tele, com_address, com_notes FROM cp_customers ORDER BY com_name ASC";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

// Query to count total customers
$count_sql = "SELECT COUNT(com_id) AS total_customers FROM cp_customers";
$count_query = mysqli_query($db, $count_sql);
$count_row = mysqli_fetch_assoc($count_query);
$total_customers = $count_row['total_customers'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Report</title>
    <!-- Bootstrap CSS (adjust path if needed) -->
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
        .total-customers {
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
        <h2>Customer Report</h2>
        <p>Generated on <?php echo date('F j, Y'); ?></p>
    </div>

    <button onclick="window.print()" class="btn btn-primary print-button">Print Report</button>

    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Address</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['com_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['com_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['com_tele']); ?></td>
                    <td><?php echo htmlspecialchars($row['com_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['com_notes']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total-customers">
        Total Customers: <?php echo $total_customers; ?>
    </div>

    <?php mysqli_close($db); ?>
</body>
</html>