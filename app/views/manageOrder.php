<?php
use App\model\user;

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    session_start();
    include __DIR__ . '/header.php'; // Include default header for non-logged-in users
}

if (!isset($user) || !$user instanceof user) {
    exit('User data is not available.');
}

// Load Bootstrap CSS
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

// Your custom styles
echo '<style>
        .table-hover tbody tr:hover {
            color: #212529;
            background-color: #f8f9fa;
        }
      </style>';
?>

<div class="panel panel-default">
    <div class="panel-heading bg-primary text-white" style="padding-left: 100px; font-size: 28px;">Orders</div>
    <div class="panel-body">
        <!-- Orders Table -->
        <div class="table-responsive">
            <table id="ordersTable" class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Date of Order</th>
                    <th>Total Price</th>
                    <th>Invoice Number</th>
                    <th>User Name</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orderDetails as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['dateOfOrder'] ?? 'Not available'); ?></td>
                        <td><?php echo htmlspecialchars($detail['totalPrice'] ?? 'Not available'); ?></td>
                        <td><?php echo htmlspecialchars($detail['invoiceNr'] ?? 'Not available'); ?></td>
                        <td><?php echo htmlspecialchars($detail['username']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form method="post">
                <div style="padding-left: 20px">
                    <h5>Select columns to export:</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="dateOfOrder" id="dateOfOrder" checked>
                        <label class="form-check-label" for="dateOfOrder">Date of Order</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="totalPrice" id="totalPrice" checked>
                        <label class="form-check-label" for="totalPrice">Total Price</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="columns[]" value="invoiceNr" id="invoiceNr" checked>
                        <label class="form-check-label" for="invoiceNr">Invoice Number</label>
                    </div>
                    <!-- Add other checkboxes for each column -->
                </div>
                <!-- Buttons for export -->
                <button type="submit" name="export_csv" class="btn btn-success">Export to CSV</button>
                <button type="submit" name="export_excel" class="btn btn-success">Export to Excel</button>
            </form>
        </div>
    </div>
</div>

<?php
// Load Bootstrap JS and other libraries
echo '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>';
echo '<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>';
echo '<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>';
echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>';

// DataTables initialization script
echo '<script>$(document).ready(function() { $("#ordersTable").DataTable(); });</script>';

include __DIR__ . '/footer.php';
?>
