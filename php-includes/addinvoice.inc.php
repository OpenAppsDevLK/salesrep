<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];

// Select the user and assign permission... (ON/OFF ADD Invoice)          
$stmt1116 = $db->prepare("SELECT cp_users.id, cp_users.firstname, cp_users.lastname, cp_userpermission.permission_id, cp_userpermission.uid, cp_userpermission.OnOff  FROM `cp_users` INNER JOIN `cp_userpermission` ON cp_users.id = cp_userpermission.uid WHERE cp_userpermission.uid = {$_SESSION['user_id']} AND cp_userpermission.permission_id = 1116" ); 
$stmt1116->bind_result($cp_users_id, $cp_users_firstname, $cp_users_lastname, $cp_userpermission_permission_id, $cp_userpermission_uid, $cp_userpermission_OnOff);
$stmt1116->execute();

while ($stmt1116->fetch()){ 
    
}


//linked with add_inv.fn.php
$ADDINV = addinvoice();


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
<?php
    // Assuming $cp_userpermission_OnOff is defined
    if ($cp_userpermission_OnOff == 0) {
        $Message .= "<h1>Access Denied</h1>";
        echo $Message;
    } else {
?>
        <h1>
            Add New Invoice
            <small>You can add Invoice to your customer...</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- General form elements disabled -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Invoice Details</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="form_addstudent" role="form" action="<?php echo $ADDINV; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Invoice ID</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <?php
                                $a = date('Y');
                                $b = rand(10000, 1000000);
                                $c = $a . $b;
                            ?>
                            <input type="number" name="txt_inv_id" value="<?php echo $c; ?>" class="form-control">
                        </div>
                    </div>

                    <?php
                        // Show all customers
                        $stmt_customers = $db->prepare("SELECT id, com_name FROM `cp_customers`");
                        $stmt_customers->bind_result($cos_id, $cos_name);
                        $stmt_customers->execute();
                    ?>
                    <div class="form-group">
                        <label>Customers</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <select name="txt_com_id" class="form-control select2" style="width: 100%;" tabindex="1">
                                <?php while ($stmt_customers->fetch()) { ?>
                                    <option value="<?php echo $cos_id; ?>"><?php echo $cos_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php $stmt_customers->close(); ?>

                    <?php
                        // Show all representatives
                        $stmt_rep = $db->prepare("SELECT id, rep_name FROM `cp_rep`");
                        $stmt_rep->bind_result($rep_ID, $rep_Name);
                        $stmt_rep->execute();
                    ?>
                    <div class="form-group">
                        <label>Rep</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <select name="txt_rep_id" class="form-control select2" style="width: 100%;" tabindex="3">
                                <?php while ($stmt_rep->fetch()) { ?>
                                    <option value="<?php echo $rep_ID; ?>"><?php echo $rep_Name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php $stmt_rep->close(); ?>

                    <?php
                        // Show all roots
                        $stmt_root = $db->prepare("SELECT id, root_name FROM `cp_root`");
                        $stmt_root->bind_result($root_ID, $root_Name);
                        $stmt_root->execute();
                    ?>
                    <div class="form-group">
                        <label>Root</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <select name="txt_root_id" class="form-control select2" style="width: 100%;" tabindex="4">
                                <?php while ($stmt_root->fetch()) { ?>
                                    <option value="<?php echo $root_ID; ?>"><?php echo $root_Name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php $stmt_root->close(); ?>

                    <div class="form-group">
                        <label>Invoice Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="date" name="txt_sys_inv_date" tabindex="5" value="" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Delivery Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <input type="date" name="txt_deli_date" tabindex="6" value="" class="form-control" required>
                        </div>
                    </div>

                    <hr>

                    <?php
                        // Show all items and prepare JavaScript data
                        $stmt_items = $db->prepare("SELECT * FROM `cp_Items`");
                        $stmt_items->bind_result($id, $item_code, $name, $notes, $cost_price, $sale_price);
                        $stmt_items->execute();
                        // Store items in an array for JavaScript
                        $items_array = [];
                        while ($stmt_items->fetch()) {
                            $items_array[] = [
                                'item_code' => $item_code,
                                'name' => $name,
                                'sale_price' => $sale_price
                            ];
                        }
                        $stmt_items->close();
                    ?>
                    <!-- Output items as JavaScript -->
                    <script>
                        var itemsData = <?php echo json_encode($items_array); ?>;
                    </script>

                    <h4 style="font-weight: 900">Add Items to the invoice</h4>
                    <div class="form-group">
                        <label>Items</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <select name="txt_items" class="form-control select2" style="width: 100%;" tabindex="4">
                                <option value="">Select Item</option>
                                <?php
                                    foreach ($items_array as $item) {
                                ?>
                                    <option value="<?php echo $item['item_code']; ?>"><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added dynamically -->
                        </tbody>
                    </table>
                    </div>
                    <hr>

                    <?php
                        // Show all items and prepare JavaScript data
                        $stmt_return_items = $db->prepare("SELECT * FROM `cp_Items`");
                        $stmt_return_items->bind_result($id, $item_code, $name, $notes, $cost_price, $sale_price);
                        $stmt_return_items->execute();
                        // Store items in an array for JavaScript
                        $retrun_items_array = [];
                        while ($stmt_return_items->fetch()) {
                            $retrun_items_array[] = [
                                'item_code' => $item_code,
                                'name' => $name,
                                'sale_price' => $sale_price
                            ];
                        }
                        $stmt_return_items->close();
                    ?>                    
                    
                    <!-- Output items as JavaScript -->
                    <script>
                        var return_itemsData = <?php echo json_encode($retrun_items_array); ?>;
                    </script>                    
                    <h4 style="font-weight: 900">Return Items</h4>
                    <div class="form-group">
                        <label>Items</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                           
                            <select name="txt_return_items" class="form-control select2" style="width: 100%;" tabindex="4">
                                <option value="">Select Item</option>
                                <?php
                                    foreach ($retrun_items_array as $item) {
                                ?>
                                    <option value="<?php echo $item['item_code']; ?>"><?php echo $item['name']; ?></option>
                                <?php } ?>
                            </select>                            
                            
                        </div>
                    </div>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </div>
                    
                <div class="summary-section">
                    <h4 id="total_no_items">Total No Items: <span class="summary-value">0</span></h4>
                    <h4 id="total_free_issues">Total No of Free Issues: <span class="summary-value">0</span></h4>
                    <h4 id="gross_total">Gross Total: <span class="summary-value">0.00</span></h4>
                    <h4 id="return_amount">Return Item Amount: <span class="summary-value">0.00</span></h4>
                    <h4 id="total_amount">Grand Total: <span class="summary-value">0.00</span></h4>
                </div>

                    <hr>

                    <div class="form-group">
                        <label>Notes</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-menu-right"></i>
                            </div>
                            <textarea class="form-control" tabindex="8" name="txt_inv_notes" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-xs-1">
                        <input style="margin-top: 5px;" tabindex="9" class="btn btn-success btn-lg" type="submit" name="btn_add_invoice" value="ADD INVOICE">
                        <a style="margin-top: 5px;" href="index.php?page=Invoice" tabindex="10" class="btn btn-primary">View All Invoices</a>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
<?php } ?>
</div><!-- /.content-wrapper -->



       <?php
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

      
      ?>