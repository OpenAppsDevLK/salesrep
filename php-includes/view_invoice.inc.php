<?php
// Browser Session Start
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user_name'];

 //Select the user and assign permission...  (ON/OFF Mark as paid)        
$stmt1130 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1130" ); 
$stmt1130->bind_result($cp_users_id1130, $cp_users_firstname1130, $cp_users_lastname1130, $cp_userpermission_permission_id1130, $cp_userpermission_uid1130, $cp_userpermission_OnOff1130);
$stmt1130->execute();

while ($stmt1130->fetch()){ 
    
}


 //Select the user and assign permission...  (ON/OFF AddPayment)        
$stmt_pid_1118 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1118" ); 
$stmt_pid_1118->bind_result($cp_users_id1118, $cp_users_firstname1118, $cp_users_lastname1118, $cp_userpermission_permission_id1118, $cp_userpermission_uid1118, $cp_userpermission_OnOff1118);
$stmt_pid_1118->execute();

while ($stmt_pid_1118->fetch()){ 
         
    if ($cp_userpermission_OnOff1118 == 0){
     
        $style_pid_1118 = "display: none;";
     
    }
}

 //Select the user and assign permission...  (ON/OFF Add Customer Signature)        
$stmt_pid_1119 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1119" ); 
$stmt_pid_1119->bind_result($cp_users_id1119, $cp_users_firstname1119, $cp_users_lastname1119, $cp_userpermission_permission_id1119, $cp_userpermission_uid1119, $cp_userpermission_OnOff1119);
$stmt_pid_1119->execute();

while ($stmt_pid_1119->fetch()){ 
         
    if ($cp_userpermission_OnOff1119 == 0){
     
        $style_pid_1119 = "display: none;";
     
    }
}

// Include database connection
include_once '../php-includes/connect.inc.php';


// Process payment form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_pay_submit'])) {
    add_inv_payment($db);
    header("Location: ".$_SERVER['PHP_SELF']."?InvID=".$_POST['txt_pay_inv_id']);
    exit();
}


// Validate and sanitize Invoice ID from URL
if (!isset($_GET['InvID']) || empty($_GET['InvID'])) {
    die("Invoice ID is missing from the URL");
}

$inv_id = mysqli_real_escape_string($db, $_GET['InvID']);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Invoice Details
            <small>You can View Invoice details...</small>
        </h1>
        <br>
        <?php
        // Fetch invoice details with error handling
        try {
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
            
            if (!$stmt_invoice) {
                throw new Exception("Prepare failed: " . $db->error);
            }
            
            $stmt_invoice->bind_param("s", $inv_id);
            
            if (!$stmt_invoice->execute()) {
                throw new Exception("Execute failed: " . $stmt_invoice->error);
            }
            
            $result_invoice = $stmt_invoice->get_result();
            $invoice = $result_invoice->fetch_assoc();
            $stmt_invoice->close();
            
            if (!$invoice) {
                throw new Exception("No invoice found with ID: " . htmlspecialchars($inv_id));
            }

            // Fetch invoice items
            $stmt_items = $db->prepare("
                SELECT item_code, item_name, order_qty, free_issues, sales_price, total
                FROM cp_invoice_items
                WHERE inv_id = ?
            ");
            
            if (!$stmt_items) {
                throw new Exception("Prepare failed: " . $db->error);
            }
            
            $stmt_items->bind_param("s", $inv_id);
            
            if (!$stmt_items->execute()) {
                throw new Exception("Execute failed: " . $stmt_items->error);
            }
            
            $result_items = $stmt_items->get_result();
            $items = [];
            while ($row = $result_items->fetch_assoc()) {
                $items[] = $row;
            }
            $stmt_items->close();

            // Fetch return items
            $stmt_return = $db->prepare("
                SELECT item_code, item_name, ret_state, ret_qty, sale_price, total
                FROM cp_return_items
                WHERE inv_id = ?
            ");
            
            if (!$stmt_return) {
                throw new Exception("Prepare failed: " . $db->error);
            }
            
            $stmt_return->bind_param("s", $inv_id);
            
            if (!$stmt_return->execute()) {
                throw new Exception("Execute failed: " . $stmt_return->error);
            }
            
            $result_return = $stmt_return->get_result();
            $return_items = [];
            while ($row = $result_return->fetch_assoc()) {
                $return_items[] = $row;
            }
            $stmt_return->close();

            // Calculate total paid amount from cp_payments
            $stmt_payments = $db->prepare("
                SELECT SUM(cash_amount + cheq_amount) as total_paid
                FROM cp_inv_payment
                WHERE p_inv_id = ?
            ");
            
            if (!$stmt_payments) {
                throw new Exception("Prepare failed: " . $db->error);
            }
            
            $stmt_payments->bind_param("s", $inv_id);
            
            if (!$stmt_payments->execute()) {
                throw new Exception("Execute failed: " . $stmt_payments->error);
            }
            
            $result_payments = $stmt_payments->get_result();
            $total_paid_row = $result_payments->fetch_assoc();
            $total_paid = $total_paid_row['total_paid'] ?? 0;
            $stmt_payments->close();

            // Calculate balance outstanding
            $balance_outstanding = $invoice['inv_grand_total'] - $total_paid;
            
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
            // You might want to stop execution here or continue with empty data
            $invoice = [];
            $items = [];
            $return_items = [];
            $total_paid = 0;
            $balance_outstanding = 0;
        }
        ?>
        
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-asterisk"></i></span>
                    <div class="info-box-content">
                        <span style="font-size: large; font-weight: 900; padding-top: 10px" class="info-box-text">Grand Total</span>
                        <span style="font-size: x-large" class="info-box-number">Rs. <?php echo isset($invoice['inv_grand_total']) ? number_format($invoice['inv_grand_total'], 2) : '0.00'; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-saved"></i></span>
                    <div class="info-box-content">
                        <span style="font-size: large; font-weight: 900; padding-top: 10px" class="info-box-text">Total Paid</span>
                        <span style="font-size: x-large" class="info-box-number">Rs. <?php echo number_format($total_paid, 2); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-share"></i></span>
                    <div class="info-box-content">
                        <span style="font-size: large; font-weight: 900; padding-top: 10px" class="info-box-text">Total Outstanding</span>
                        <span style="font-size: x-large" class="info-box-number">Rs. <?php echo number_format($balance_outstanding, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Invoice Details</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form id="form_addstudent" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Invoice ID</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_id" value="<?php echo isset($invoice['inv_id']) ? htmlspecialchars($invoice['inv_id']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Customer</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_customer" value="<?php echo isset($invoice['com_name']) ? htmlspecialchars($invoice['com_name']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Rep</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_rep" value="<?php echo isset($invoice['rep_name']) ? htmlspecialchars($invoice['rep_name']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Root</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_root" value="<?php echo isset($invoice['root_name']) ? htmlspecialchars($invoice['root_name']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Invoice Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_date" value="<?php echo isset($invoice['inv_invoice_date']) ? htmlspecialchars($invoice['inv_invoice_date']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Delivery Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="text" name="txt_inv_delivery_date" value="<?php echo isset($invoice['inv_delivery_date']) ? htmlspecialchars($invoice['inv_delivery_date']) : ''; ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <hr>
                    <h4 style="font-weight: 900">Invoiced Items</h4>
                    <div class="box-body table-responsive no-padding">
                        <table id="tbl_added_items" class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Order Qty</th>
                                    <th>Free Qty</th>
                                    <th>Sales Price</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($items)): ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['item_code']); ?></td>
                                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['order_qty']); ?></td>
                                            <td><?php echo htmlspecialchars($item['free_issues']); ?></td>
                                            <td><?php echo number_format($item['sales_price'], 2); ?></td>
                                            <td><?php echo number_format($item['total'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No items found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-4">
                            <h4>Total No Items: <span class="summary-value"><?php echo isset($invoice['inv_total_items']) ? htmlspecialchars($invoice['inv_total_items']) : 0; ?></span></h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Total No of Free Issues: <span class="summary-value"><?php echo isset($invoice['inv_free_issues']) ? htmlspecialchars($invoice['inv_free_issues']) : 0; ?></span></h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Invoiced Total: <span class="summary-value"><?php echo isset($invoice['inv_gross_total']) ? number_format($invoice['inv_gross_total'], 2) : '0.00'; ?></span></h4>
                        </div>
                    </div>
                    <hr>

                    <h4 style="font-weight: 900">Return Items</h4>
                    <div class="box-body table-responsive no-padding">
                        <table id="tbl_return_items" class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>States</th>
                                    <th>Qty</th>
                                    <th>Sales Price</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($return_items)): ?>
                                    <?php foreach ($return_items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['item_code']); ?></td>
                                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['ret_state']); ?></td>
                                            <td><?php echo htmlspecialchars($item['ret_qty']); ?></td>
                                            <td><?php echo number_format($item['sale_price'], 2); ?></td>
                                            <td><?php echo number_format($item['total'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No return items found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-6">
                            <h4>Total Return Items: <span class="summary-value"><?php echo count($return_items); ?></span></h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Return Item Amount: <span class="summary-value"><?php echo isset($invoice['inv_return_item_amount']) ? number_format($invoice['inv_return_item_amount'], 2) : '0.00'; ?></span></h4>
                        </div>
                    </div>
                    <hr>
                    
                    
                        <?php
                        // Fetch payment details for this invoice
                        $stmt_payments = $db->prepare("
                            SELECT 
                                payment_id,
                                pay_date,
                                cash_amount,
                                cheq_amount,
                                cheq_date,
                                cheq_detail,
                                notes
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

                        <h4 style="font-weight: 900">Payment Received</h4>
                        <div class="box-body table-responsive no-padding">
                            <table id="tbl_payments" class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Paid Date</th>
                                        <th>Cash Amount</th>
                                        <th>Cheq. Amount</th>
                                        <th>Cheq. Date</th>
                                        <th>Cheq. Details</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($payments)): ?>
                                        <?php foreach ($payments as $payment): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($payment['payment_id']) ?></td>
                                                <td><?= htmlspecialchars($payment['pay_date']) ?></td>
                                                <td class="text-right"><?= number_format($payment['cash_amount'], 2) ?></td>
                                                <td class="text-right"><?= number_format($payment['cheq_amount'], 2) ?></td>
                                                <td><?= htmlspecialchars($payment['cheq_date']) ?></td>
                                                <td><?= htmlspecialchars($payment['cheq_detail']) ?></td>
                                                <td><?= htmlspecialchars($payment['notes']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No payments found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                                        
                        <hr>                   
                    <div class="form-group">
                        <label>Notes</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <textarea class="form-control" tabindex="8" name="txt_inv_notes" rows="4" readonly><?php echo isset($invoice['inv_notes']) ? htmlspecialchars($invoice['inv_notes']) : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="col-lg-6 col-md-12 col-xs-1">
                            <button style="margin-top: 5px; <?php echo $style_pid_1118; ?>" type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#changeMsg1">Add Payment</button>

                            <button style="margin-top: 5px;" type="button" class="btn btn-success btn-flat" 
                                    onclick="window.open('output/print_invoice.php?InvID=<?= $inv_id ?>', '_blank')">
                                Print Invoice
                            </button>
                            
                            <button style="margin-top: 5px;" type="button" class="btn btn-success btn-flat" onclick="window.open('output/print_invoice_payments.php?InvID=<?= $inv_id ?>', '_blank')">Print Payment</button> 
                            <button style="margin-top: 5px; <?php echo $style_pid_1119; ?>" type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#signatureModal">Add Customer Signature</button>

                             <?php
                             
                                if ($cp_userpermission_OnOff1130 == 0){

                                    $style_pid_1130 = "display: none;";

                                }
 
                            ?>
                            
                            <a style="margin-top: 5px; <?php echo $style_pid_1130; ?>" href="actions/mark_paid.php?InvID=<?= $inv_id ?>" 
                            class="btn btn-danger btn-flat" 
                            onclick="return confirmMarkAsPaid()">Mark as Paid</a>
                            
                            <input style="margin-top: 5px;" type="button" class="btn btn-primary btn-flat" value="Refresh" onclick="window.location.href = window.location.href;" />
                        </div>
                    </div>
                </form>

                <!-- Modal Window for Add Payment -->
                <div class="modal fade modal-success" id="changeMsg1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="form_addpayment" role="form" action="" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add Payment</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Invoice ID</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="text" name="txt_pay_inv_id" value="<?php echo htmlspecialchars($inv_id); ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="date" name="txt_pay_date" value="" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Cash Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="text" name="txt_pay_cash_amount" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Cheque Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="text" name="txt_pay_chq_amount" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Cheque Date</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="date" name="txt_pay_chq_date" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Cheque Details (Chq.No-Bank Code-Branch Code)</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <input type="text" name="txt_pay_chq_no" data-inputmask="'mask': ['999999-9999-999]', '+099 99 99 9999[9]-9999']" data-mask="" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Notes</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </div>
                                            <textarea class="form-control" name="txt_pay_notes" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input class="btn btn-outline btn-flat" type="submit" name="btn_pay_submit" value="ADD PAYMENT">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                
<!-- Signature Modal -->
<div class="modal fade" id="signatureModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Customer Signature</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="signature-container">
                    <canvas id="signature-pad"></canvas>
                </div>
                <div class="signature-actions">
                    <button id="clear-signature" class="btn btn-default">Clear</button>
                    <button id="save-signature" class="btn btn-primary">Save Signature</button>
                </div>
            </div>
        </div>
    </div>
</div>
                
                
            </div>
        </div>
    </section>
</div>