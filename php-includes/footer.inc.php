<?php
// Browser Session Start here
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
	$user = $_SESSION['user_name'];
	

?>



<footer class="main-footer">
    Thank you for using SaleRep, by  <a href="https://openapps.dev">OpenApps.Dev</a>  | <a href="https://openapps.dev/licence/">License.</a> 
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>


    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script> 
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>


    
    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>


<script>
$(document).ready(function() {
    // Initialize Select2 for all dropdowns
    $('.select2').select2();

    // Function to update summary fields
    function updateSummary() {
        let totalItems = $('#tbl_added_items tbody tr').length; // Count rows in Add Items table
        let totalFreeIssues = 0;
        let grossTotal = 0;
        let returnAmount = 0;

        // Calculate totals for Add Items table
        $('#tbl_added_items tbody tr').each(function() {
            const freeQty = parseFloat($(this).find('.free-qty').val()) || 0;
            const value = parseFloat($(this).find('.value').val()) || 0;

            totalFreeIssues += freeQty;
            grossTotal += value;
        });

        // Calculate totals for Return Items table
        $('#tbl_return_items tbody tr').each(function() {
            const value = parseFloat($(this).find('.value').val()) || 0;
            returnAmount += value;
        });

        // Update summary fields
        $('#total_no_items').text(`Total No Items: ${totalItems}`);
        $('#total_free_issues').text(`Total No of Free Issues: ${totalFreeIssues}`);
        $('#gross_total').text(`Gross Total: Rs  ${grossTotal.toFixed(2)}`);
        $('#return_amount').text(`Return Item Amount: Rs ${returnAmount.toFixed(2)}`);
        $('#total_amount').text(`Grand Total: Rs ${(grossTotal - returnAmount).toFixed(2)}`);
    }

    // Handle change event on the items dropdown (Add Items)
    $('select[name="txt_items"]').on('change', function() {
        var selectedItemCode = $(this).val();
        if (!selectedItemCode) return;

        var selectedItem = itemsData.find(function(item) {
            return item.item_code === selectedItemCode;
        });

        if (selectedItem) {
            var newRow = `
                <tr>
                    <td>${selectedItem.item_code}</td>
                    <td>${selectedItem.name}</td>
                    <td><input type="number" name="txt_inv_orderQty[]" value="0" class="form-control order-qty" min="0"></td>
                    <td><input type="number" name="txt_inv_FreeQty[]" value="0" class="form-control free-qty" min="0"></td>
                    <td><input type="number" name="txt_inv_SalesPrice[]" value="${selectedItem.sale_price}" class="form-control sales-price" readonly></td>
                    <td><input type="number" name="txt_inv_value[]" value="0" class="form-control value" readonly></td>
                    <td><button type="button" class="btn btn-danger delete-row"><span class="glyphicon glyphicon-trash"></span></button></td>
                    
                    <input type="hidden" name="txt_items_code[]" value="${selectedItem.item_code}">
                    <input type="hidden" name="txt_items_name[]" value="${selectedItem.name}">
                    </tr>
            `;
            $('#tbl_added_items tbody').append(newRow);
            $(this).val('').trigger('change');
            updateSummary(); // Update summary after adding row
        }
    });

    // Handle change event on the return items dropdown (Return Items)
    $('select[name="txt_return_items"]').on('change', function() {
        var selectedItemCode = $(this).val();
        if (!selectedItemCode) return;

        var selectedItem = itemsData.find(function(item) {
            return item.item_code === selectedItemCode;
        });

        if (selectedItem) {
            var newRow = `
                <tr>
                    <td>${selectedItem.item_code}</td>
                    <td>${selectedItem.name}</td>
                    <td>
                        <select name="txt_return_states[]" class="form-control select2 state-select" style="width: 100%;">
                            <option value="Expired">Expired</option>
                            <option value="Damaged Item">Damaged Item</option>
                        </select>
                    </td>
                    <td><input type="number" name="txt_inv_ReturnQty[]" value="0" class="form-control return-qty" min="0"></td>
                    <td><input type="number" name="txt_inv_Re_SalesPrice[]" value="${selectedItem.sale_price}" class="form-control sales-price" readonly></td>
                    <td><input type="number" name="txt_inv_Re_value[]" value="0" class="form-control value" readonly></td>
                    <td><button type="button" class="btn btn-danger delete-row"><span class="glyphicon glyphicon-trash"></span></button></td>
               
                <input type="hidden" name="txt_return_items_code[]" value="${selectedItem.item_code}">
                <input type="hidden" name="txt_return_items_name[]" value="${selectedItem.name}">
             </tr>
            `;
            $('#tbl_return_items tbody').append(newRow);
            $('#tbl_return_items .state-select').select2();
            $(this).val('').trigger('change');
            updateSummary(); // Update summary after adding row
        }
    });

    // Handle delete button click to remove a row (shared for both tables)
    $(document).on('click', '.delete-row', function() {
        $(this).closest('tr').remove();
        updateSummary(); // Update summary after removing row
    });

    // Update value field and summary for Add Items table
    $(document).on('input', '.order-qty, .free-qty', function() {
        var $row = $(this).closest('tr');
        var orderQty = parseFloat($row.find('.order-qty').val()) || 0;
        var salesPrice = parseFloat($row.find('.sales-price').val()) || 0;
        var value = orderQty * salesPrice;
        $row.find('.value').val(value.toFixed(2));
        updateSummary(); // Update summary after quantity change
    });

    // Update value field and summary for Return Items table
    $(document).on('input', '.return-qty', function() {
        var $row = $(this).closest('tr');
        var returnQty = parseFloat($row.find('.return-qty').val()) || 0;
        var salesPrice = parseFloat($row.find('.sales-price').val()) || 0;
        var value = returnQty * salesPrice;
        $row.find('.value').val(value.toFixed(2));
        updateSummary(); // Update summary after quantity change
    });

    // Initial update of summary fields
    updateSummary();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (isset($_SESSION['alert'])): ?>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['type'] ?>',
        title: '<?= $_SESSION['alert']['message'] ?>',
        showConfirmButton: false,
        timer: 2000
    });
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>
</script>




<script>
$(document).ready(function() {
    // Initialize signature pad after modal is shown
    $('#signatureModal').on('shown.bs.modal', function() {
        initSignaturePad();
    });

    function initSignaturePad() {
        const canvas = document.getElementById('signature-pad');
        const container = document.querySelector('.signature-container');
        
        // Set canvas dimensions based on container
        canvas.width = container.offsetWidth;
        canvas.height = container.offsetHeight;
        
        // Initialize signature pad
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Clear button
        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Save button
        document.getElementById('save-signature').addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                alert('Please provide a signature first.');
                return;
            }

            const signatureData = signaturePad.toDataURL('image/png');

            // Save to database via AJAX
            $.ajax({
                url: 'output/save_signature.php',
                type: 'POST',
                data: {
                    inv_id: '<?= $inv_id ?>',
                    signature: signatureData
                },
                success: function(response) {
                    // On success, open print page without passing signature in URL
                    window.open('output/print_invoice.php?InvID=<?= $inv_id ?>', '_blank');
                    $('#signatureModal').modal('hide');
                },
                error: function(xhr) {
                    alert('Error saving signature. Please try again.');
                }
            });
        });
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Delete invoice button click handler
    $(document).on('click', '.delete-invoice', function() {
        var invoiceId = $(this).data('invoiceid');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'actions/delete_invoice.php',
                    type: 'POST',
                    data: { invoice_id: invoiceId },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'Invoice has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Refresh the page
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete invoice: ' + xhr.responseText,
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>


<script>
function confirmMarkAsPaid() {
    event.preventDefault(); // Prevent default link behavior
    const url = event.target.getAttribute('href');
    
    Swal.fire({
        title: 'Mark Invoice as Paid?',
        text: "This will update the payment status of this invoice",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, mark as paid'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Proceed if confirmed
        }
    });
    
    return false; // Prevent default link behavior
}
</script>

<?php if (isset($_SESSION['alert'])): ?>
<script>
Swal.fire({
    icon: '<?= $_SESSION['alert']['type'] ?>',
    title: '<?= $_SESSION['alert']['message'] ?>',
    showConfirmButton: false,
    timer: 3000
});
</script>
<?php unset($_SESSION['alert']); endif; ?>
    
  </body>
</html>

 <?php
    // If session isn't meet, user will redirect to login page
} else { 
    header('Location: login.php');
}

      
?>