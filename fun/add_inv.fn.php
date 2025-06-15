<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
    $user = $_SESSION['user_name'];
    
    // Include database connection
    include_once '../php-includes/connect.inc.php'; 

    function addinvoice() {
        global $db; // Access the database connection

        if(isset($_POST['btn_add_invoice'])) {
            // Get invoice details from form
            $inv_id = mysqli_real_escape_string($db, $_POST['txt_inv_id']);
            $inv_cos_id = mysqli_real_escape_string($db, $_POST['txt_com_id']);
            $inv_rep_id = mysqli_real_escape_string($db, $_POST['txt_rep_id']);
            $inv_root_id = mysqli_real_escape_string($db, $_POST['txt_root_id']);
            $inv_invoice_date = mysqli_real_escape_string($db, $_POST['txt_sys_inv_date']);
            $inv_delivery_date = mysqli_real_escape_string($db, $_POST['txt_deli_date']);
            $inv_notes = mysqli_real_escape_string($db, $_POST['txt_inv_notes']);

            // Calculate summary fields
            $inv_total_items = 0; // Number of rows in added items
            $inv_free_issues = 0; // Sum of free quantities
            $inv_gross_total = 0; // Sum of values for added items
            $inv_return_item_amount = 0; // Sum of values for return items

            // Process added items (if any)
            if (!empty($_POST['txt_inv_orderQty'])) {
                $inv_total_items = count($_POST['txt_inv_orderQty']);
                foreach ($_POST['txt_inv_orderQty'] as $index => $order_qty) {
                    $free_qty = isset($_POST['txt_inv_FreeQty'][$index]) ? floatval($_POST['txt_inv_FreeQty'][$index]) : 0;
                    $sales_price = isset($_POST['txt_inv_SalesPrice'][$index]) ? floatval($_POST['txt_inv_SalesPrice'][$index]) : 0;
                    $inv_free_issues += $free_qty;
                    $inv_gross_total += $order_qty * $sales_price;
                }
            }

            // Process return items (if any)
            if (!empty($_POST['txt_inv_ReturnQty'])) {
                foreach ($_POST['txt_inv_ReturnQty'] as $index => $ret_qty) {
                    $sales_price = isset($_POST['txt_inv_Re_SalesPrice'][$index]) ? floatval($_POST['txt_inv_Re_SalesPrice'][$index]) : 0;
                    $inv_return_item_amount += $ret_qty * $sales_price;
                }
            }

            // Calculate grand total
            $inv_grand_total = $inv_gross_total - $inv_return_item_amount;

            // Insert into cp_invoice table
            $stmt_invoice = $db->prepare("INSERT INTO cp_invoice (
                inv_id, inv_cos_id, inv_rep_id, inv_root_id, inv_invoice_date, 
                inv_delivery_date, inv_total_items, inv_free_issues, 
                inv_gross_total, inv_return_item_amount, inv_grand_total, inv_notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_invoice->bind_param(
                "siiisssiddds",
                $inv_id,
                $inv_cos_id,
                $inv_rep_id,
                $inv_root_id,
                $inv_invoice_date,
                $inv_delivery_date,
                $inv_total_items,
                $inv_free_issues,
                $inv_gross_total,
                $inv_return_item_amount,
                $inv_grand_total,
                $inv_notes
            );

            if ($stmt_invoice->execute()) {
                // Insert into cp_invoice_items table
                if (!empty($_POST['txt_inv_orderQty'])) {
                    $stmt_items = $db->prepare("INSERT INTO cp_invoice_items (
                        inv_id, item_code, item_name, order_qty, free_issues, sales_price, total
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    
                    foreach ($_POST['txt_inv_orderQty'] as $index => $order_qty) {
                        $order_qty = floatval($order_qty);
                        $free_issues = isset($_POST['txt_inv_FreeQty'][$index]) ? floatval($_POST['txt_inv_FreeQty'][$index]) : 0;
                        $sales_price = isset($_POST['txt_inv_SalesPrice'][$index]) ? floatval($_POST['txt_inv_SalesPrice'][$index]) : 0;
                        $total = $order_qty * $sales_price;

                        // Fetch item_code and item_name from itemsData or POST
                        $item_code = isset($_POST['txt_items_code'][$index]) ? mysqli_real_escape_string($db, $_POST['txt_items_code'][$index]) : '';
                        $item_name = isset($_POST['txt_items_name'][$index]) ? mysqli_real_escape_string($db, $_POST['txt_items_name'][$index]) : '';

                        $stmt_items->bind_param(
                            "sssiidd",
                            $inv_id,
                            $item_code,
                            $item_name,
                            $order_qty,
                            $free_issues,
                            $sales_price,
                            $total
                        );
                        $stmt_items->execute();
                    }
                    $stmt_items->close();
                }

                // Insert into cp_return_items table
                if (!empty($_POST['txt_inv_ReturnQty'])) {
                    $stmt_return = $db->prepare("INSERT INTO cp_return_items (
                        inv_id, item_code, item_name, ret_state, ret_qty, sale_price, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    
                    foreach ($_POST['txt_inv_ReturnQty'] as $index => $ret_qty) {
                        $ret_qty = floatval($ret_qty);
                        $sale_price = isset($_POST['txt_inv_Re_SalesPrice'][$index]) ? floatval($_POST['txt_inv_Re_SalesPrice'][$index]) : 0;
                        $total = $ret_qty * $sale_price;
                        $ret_state = isset($_POST['txt_return_states'][$index]) ? mysqli_real_escape_string($db, $_POST['txt_return_states'][$index]) : '';

                        // Fetch item_code and item_name from return items
                        $item_code = isset($_POST['txt_return_items_code'][$index]) ? mysqli_real_escape_string($db, $_POST['txt_return_items_code'][$index]) : '';
                        $item_name = isset($_POST['txt_return_items_name'][$index]) ? mysqli_real_escape_string($db, $_POST['txt_return_items_name'][$index]) : '';

                        $stmt_return->bind_param(
                            "ssssdss",
                            $inv_id,
                            $item_code,
                            $item_name,
                            $ret_state,
                            $ret_qty,
                            $sale_price,
                            $total
                            
                        );
                        $stmt_return->execute();
                    }
                    $stmt_return->close();
                }

                $stmt_invoice->close();
                //Redirect to the page after inset 
                echo "<script>location='index.php?page=Invoice&PageNo=1'</script>";
                exit();
            } else {
                // Handle error
                echo "Error inserting invoice: " . $db->error;
            }
        }
    }  
    
// If session isn't met, user will redirect to login page
} else { 
    header('Location: ../login.php');
}
?>
