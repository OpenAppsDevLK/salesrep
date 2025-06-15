<?php

include_once '../php-includes/connect.inc.php';

// Query to fetch all representatives
$sql = "SELECT rep_id, rep_name, rep_address, rep_mob1, rep_mob2, rep_notes FROM cp_rep ORDER BY rep_name ASC";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Query failed: " . mysqli_error($db));
}

// Query to count total representatives
$count_sql = "SELECT COUNT(rep_id) AS total_reps FROM cp_rep";
$count_query = mysqli_query($db, $count_sql);
$count_row = mysqli_fetch_assoc($count_query);
$total_reps = $count_row['total_reps'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Representative Report</title>
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
        .total-reps {
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
        <h2>Representative Report</h2>
        <p>Generated on <?php echo date('F j, Y'); ?></p>
    </div>

    <button onclick="window.print()" class="btn btn-primary print-button">Print Report</button>

    <table class="table table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>Rep ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Mobile 1</th>
                <th>Mobile 2</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['rep_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['rep_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['rep_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['rep_mob1']); ?></td>
                    <td><?php echo htmlspecialchars($row['rep_mob2'] ?: '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['rep_notes'] ?: '-'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total-reps">
        Total Representatives: <?php echo $total_reps; ?>
    </div>

    <?php mysqli_close($db); ?>
</body>
</html>