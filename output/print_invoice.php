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

// Fetch invoice details
$stmt_invoice = $db->prepare("
    SELECT 
        i.inv_id,
        c.com_name,
        r.rep_name,
        rt.root_name,
        i.inv_invoice_date,
        i.inv_delivery_date,
        i.inv_total_items,
        i.inv_free_issues,
        i.inv_gross_total,
        i.inv_return_item_amount,
        i.inv_grand_total,
        i.inv_notes
    FROM cp_invoice i
    LEFT JOIN cp_customers c ON i.inv_cos_id = c.id
    LEFT JOIN cp_rep r ON i.inv_rep_id = r.id
    LEFT JOIN cp_root rt ON i.inv_root_id = rt.id
    WHERE i.inv_id = ?
");
$stmt_invoice->bind_param("s", $inv_id);
$stmt_invoice->execute();
$result_invoice = $stmt_invoice->get_result();
$invoice = $result_invoice->fetch_assoc();
$stmt_invoice->close();

// Fetch invoice items
$stmt_items = $db->prepare("
    SELECT item_code, item_name, order_qty, free_issues, sales_price, total
    FROM cp_invoice_items
    WHERE inv_id = ?
");
$stmt_items->bind_param("s", $inv_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
$items = $result_items->fetch_all(MYSQLI_ASSOC);
$stmt_items->close();

// Fetch return items
$stmt_return = $db->prepare("
    SELECT item_code, item_name, ret_state, ret_qty, sale_price, total
    FROM cp_return_items
    WHERE inv_id = ?
");
$stmt_return->bind_param("s", $inv_id);
$stmt_return->execute();
$result_return = $stmt_return->get_result();
$return_items = $result_return->fetch_all(MYSQLI_ASSOC);
$stmt_return->close();

// Fetch payments
$stmt_payments = $db->prepare("
    SELECT payment_id, pay_date, cash_amount, cheq_amount, cheq_detail, notes
    FROM cp_inv_payment
    WHERE p_inv_id = ?
    ORDER BY pay_date DESC
");
$stmt_payments->bind_param("s", $inv_id);
$stmt_payments->execute();
$result_payments = $stmt_payments->get_result();
$payments = $result_payments->fetch_all(MYSQLI_ASSOC);
$stmt_payments->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $inv_id ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p><strong>Invoice #:</strong> <?= htmlspecialchars($invoice['inv_id']) ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($invoice['inv_invoice_date']) ?></p>
                <p><strong>Delivery Date:</strong> <?= htmlspecialchars($invoice['inv_delivery_date']) ?></p>
            </div>
<!--            <div class="company-info">
                <h2>YOUR COMPANY NAME</h2>
                <p>123 Business Street, City</p>
                <p>Phone: xxxxxxxxxxxx</p>
                <p>Email: xxxx@xxxxxxxx.com</p>
            </div>-->
        </div>

        <div style="margin-bottom: 20px;">
            <div><strong>Customer:</strong> <?= htmlspecialchars($invoice['com_name']) ?></div>
            <div><strong>Sales Rep:</strong> <?= htmlspecialchars($invoice['rep_name']) ?></div>
            <div><strong>Route:</strong> <?= htmlspecialchars($invoice['root_name']) ?></div>
        </div>

        <!-- Items Table -->
        <h3>ITEMS SOLD</h3>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Free</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_code']) ?></td>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= htmlspecialchars($item['order_qty']) ?></td>
                        <td><?= htmlspecialchars($item['free_issues']) ?></td>
                        <td class="text-right">Rs. <?= number_format($item['sales_price'], 2) ?></td>
                        <td class="text-right">Rs. <?= number_format($item['total'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No items found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Items Summary -->
        <div class="summary-box">
            <div>
                <p><strong>Total Items:</strong> <?= htmlspecialchars($invoice['inv_total_items']) ?></p>
            </div>
            <div>
                <p><strong>Total Free Issues:</strong> <?= htmlspecialchars($invoice['inv_free_issues']) ?></p>
            </div>
        </div>

        <!-- Return Items Table -->
        <?php if (!empty($return_items)): ?>
        <h3>RETURN ITEMS</h3>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($return_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_code']) ?></td>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= htmlspecialchars($item['ret_state']) ?></td>
                    <td><?= htmlspecialchars($item['ret_qty']) ?></td>
                    <td class="text-right">Rs. <?= number_format($item['sale_price'], 2) ?></td>
                    <td class="text-right">Rs. <?= number_format($item['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary-box">
            <div>
                <p><strong>Total Return Items:</strong> <?= count($return_items) ?></p>
            </div>
            <div>
                <p><strong>Return Item Amount:</strong> Rs. <?= number_format($invoice['inv_return_item_amount'], 2) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Totals Section -->
        <div class="total-section">
            <p><strong>Gross Total:</strong> Rs. <?= number_format($invoice['inv_gross_total'], 2) ?></p>
            <?php if ($invoice['inv_return_item_amount'] > 0): ?>
            <p><strong>Less: Return Amount:</strong> Rs. <?= number_format($invoice['inv_return_item_amount'], 2) ?></p>
            <?php endif; ?>
            <p style="font-size: 1.2em;"><strong>GRAND TOTAL:</strong> Rs. <?= number_format($invoice['inv_grand_total'], 2) ?></p>
        </div>


        <!-- Notes -->
        <?php if (!empty($invoice['inv_notes'])): ?>
        <h3>NOTES</h3>
        <div style="padding: 10px; background: #f9f9f9; border-radius: 4px;">
            <?= nl2br(htmlspecialchars($invoice['inv_notes'])) ?>
        </div>
        <?php endif; ?>
        
        <?php 
        // Check for saved signature
        $signatureData = isset($_SESSION['customerSignature']) ? $_SESSION['customerSignature'] : '';
        if (empty($signatureData)) {
            // Fallback to local storage data if available
            $signatureData = isset($_GET['signature']) ? $_GET['signature'] : '';
        }
        ?>

<?php

// Get invoice ID
$inv_id = isset($_GET['InvID']) ? mysqli_real_escape_string($db, $_GET['InvID']) : '';

// Fetch signature from database
$signatureData = '';
$stmt = $db->prepare("SELECT customer_signature FROM cp_invoice WHERE inv_id = ?");
$stmt->bind_param("s", $inv_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $signatureData = $row['customer_signature'];
}
$stmt->close();
?>

<!-- Display signature if available -->
<?php if (!empty($signatureData)): ?>
<div style="margin-top: 40px; page-break-inside: avoid;">
    <div style="float: right; text-align: center;">
        <img src="<?= htmlspecialchars($signatureData) ?>" 
             style="max-width: 200px; max-height: 80px; display: block; margin: 0 auto;">
        <div style="border-top: 1px solid #000; width: 200px; margin: 5px auto 0;"></div>
        <p><strong>Customer Signature</strong></p>
        <p>Date: <?= date('Y-m-d') ?></p>
    </div>
    <div style="clear: both;"></div>
</div>
<?php endif; ?>

        <div class="no-print" id="action-buttons" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" class="btn btn-success">Print Invoice</button>
            <button onclick="generatePDF()" class="btn btn-success">Download PDF</button>
            <button onclick="window.close()" class="btn btn-default">Close</button>
        </div>
    </div>
    
    
<script>
window.jsPDF = window.jspdf.jsPDF;

function generatePDF() {
    // Hide buttons before capturing
    const actionButtons = document.getElementById('action-buttons');
    actionButtons.style.display = 'none';
    
    // Show loading message
    const loading = document.createElement('div');
    loading.innerHTML = `
        <div style="
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 9999;
        ">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p>Generating PDF, please wait...</p>
        </div>
    `;
    document.body.appendChild(loading);

    // Capture the invoice content
    const element = document.querySelector('.invoice-box');
    const options = {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#FFFFFF'
    };

    html2canvas(element, options).then(canvas => {
        // Create PDF
        const imgData = canvas.toDataURL('image/png', 1.0);
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('Invoice_<?= $inv_id ?>.pdf');
        
        // Clean up
        document.body.removeChild(loading);
        actionButtons.style.display = 'block';
    }).catch(error => {
        console.error('Error generating PDF:', error);
        alert('Error generating PDF. Please try again.');
        document.body.removeChild(loading);
        actionButtons.style.display = 'block';
    });
}
</script>
</body>
</html>