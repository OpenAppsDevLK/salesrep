<?php

include_once '../php-includes/connect.inc.php';

// Query to fetch all roots
$sql = "SELECT root_id, root_name, root_notes FROM cp_root ORDER BY root_name ASC";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

// Query to count total roots
$count_sql = "SELECT COUNT(root_id) AS total_roots FROM cp_root";
$count_query = mysqli_query($db, $count_sql);
$count_row = mysqli_fetch_assoc($count_query);
$total_roots = $count_row['total_roots'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Root Report</title>
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
        .total-roots {
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
        <h2>Root Report</h2>
        <p>Generated on <?php echo date('F j, Y'); ?></p>
    </div>

    <button onclick="window.print()" class="btn btn-primary print-button">Print Report</button>

    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>Root ID</th>
                <th>Name</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['root_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['root_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['root_notes'] ?: '-'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total-roots">
        Total Roots: <?php echo $total_roots; ?>
    </div>

    <?php mysqli_close($db); ?>
</body>
</html>