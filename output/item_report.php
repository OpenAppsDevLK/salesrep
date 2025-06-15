<?php

require_once '../php-includes/connect.inc.php'; 

// Query to fetch all items
$sql = "SELECT id, item_code, name, notes, cost_price, sale_price FROM cp_Items ORDER BY name ASC";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

// Query to count total items
$count_sql = "SELECT COUNT(id) AS total_items FROM cp_Items";
$count_query = mysqli_query($db, $count_sql);
$count_row = mysqli_fetch_assoc($count_query);
$total_items = $count_row['total_items'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item Report</title>
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
        .total-items {
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
        <h2>Item Report</h2>
        <p>Generated on <?php echo date('F j, Y'); ?></p>
    </div>

    <button onclick="window.print()" class="btn btn-primary print-button">Print Report</button>

    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Name</th>
                <th>Notes</th>
                <th>Cost Price</th>
                <th>Sale Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['item_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['notes']); ?></td>
                    <td><?php echo number_format($row['cost_price'], 2); ?></td>
                    <td><?php echo number_format($row['sale_price'], 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total-items">
        Total Items: <?php echo $total_items; ?>
    </div>

    <?php mysqli_close($db); ?>
</body>
</html>