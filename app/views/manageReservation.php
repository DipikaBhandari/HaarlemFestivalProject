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
    <div class="row">
        <div id="spinner" class="spinner" style="display:none;"></div>
        <div style="padding-left: 40px;">
            <h2 class="page-title">Manage Reservation</h2>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="ordersTable" class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Event Name</th>

                    <th>Date</th>
                    <th> Start Time</th>
                    <th>End Time</th>
                    <th>Special Request</th>
                    <th>Number of Ticket</th>
                    <th>Price</th>
                    <th>status</th>
                    <th>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHistoryModal">Add</button>-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addReservationModal">Add New Reservation</button>

                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reservationDetails as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['eventName']); ?></td>
                        <td><?php echo htmlspecialchars($detail['date']); ?></td>
                        <td><?php echo (new DateTime($detail['startTime']))->format('H:i'); ?></td>
                        <td><?php echo (new DateTime($detail['endTime']))->format('H:i'); ?></td>
                        <td><?php echo isset($detail['specialRequest']) && !empty($detail['specialRequest']) ? htmlspecialchars($detail['specialRequest']) : 'None'; ?></td>
                        <td><?php echo htmlspecialchars($detail['numberOfTickets']); ?></td>
                        <td><?php echo isset($detail['price']) ? htmlspecialchars($detail['price']). ' &euro;' : 'N/A';?></td>
                        <td><?php echo isset($detail['status']) ? htmlspecialchars($detail['status']) : 'Pending'; ?></td>
                        <td>
                            <a onclick="openEditModal('<?php echo htmlentities($detail['orderItemId']);?>')" >&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                            <a onclick="deleteUser('<?php echo htmlentities($detail['orderItemId']); ?>')" ><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Add Reservation Modal -->
            <div class="modal fade" id="addReservationModal" tabindex="-1" role="dialog" aria-labelledby="addReservationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addReservationModalLabel">Add New Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addReservationForm">
                                <div class="form-group">
                                    <label for="addEventName">Event Name</label>
                                    <input type="text" class="form-control" id="addEventName" name="eventName" required>
                                </div>
                                <div class="form-group">
                                    <label for="restaurantSection">Restaurant Section</label>
                                    <select class="form-control" id="restaurantSection" name="restaurantSectionId" required>
                                        <?php foreach ($getAllRestaurantSections as $detail): ?>
                                            <option value="<?=  ($detail['restaurantSectionId']); ?>"><?php echo htmlspecialchars($detail['restaurantName']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="addDate">Date</label>
                                    <input type="date" class="form-control" id="addDate" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="addStartTime">Start Time</label>
                                    <input type="time" class="form-control" id="addStartTime" name="startTime" required>
                                </div>
                                <div class="form-group">
                                    <label for="addEndTime">End Time</label>
                                    <input type="time" class="form-control" id="addEndTime" name="endTime" required>
                                </div>
                                <div class="form-group">
                                    <label for="addSpecialRequest">Special Request</label>
                                    <input type="text" class="form-control" id="addSpecialRequest" name="specialRequest">
                                </div>
                                <div class="form-group">
                                    <label for="addNumberOfTickets">Number of Tickets</label>
                                    <input type="number" class="form-control" id="addNumberOfTickets" name="numberOfTickets" required>
                                </div>

                                <div class="form-group">
                                    <label for="addStatus">Status</label>
                                    <select class="form-control" id="addStatus" name="status">
                                        <option value="Pending">Pending</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>



            <!-- Edit User Modal -->
            <div class="modal fade" id="editReservationModal" tabindex="-1" role="dialog" aria-labelledby="editReservationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editReservationModalLabel">Edit Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" ">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="spinner" class="spinner" style="display:none;"></div>

                            <!-- ...existing modal content... -->

                            <form id="editReservationForm">
                                <input type="hidden" id="editReservationId">

                                <div class="form-group">
                                    <label for="editEventName">Event Name</label>
                                    <input type="text" class="form-control" id="editEventName" name="eventName" required>
                                </div>

                                <div class="form-group">
                                    <label for="editDate">Date</label>
                                    <input type="text" class="form-control" id="editDate" name="date" required>
                                </div>

                                <div class="form-group">
                                    <label for="editStartTime">Start Time</label>
                                    <input type="time" class="form-control" id="editStartTime" name="startTime" required>
                                </div>

                                <div class="form-group">
                                    <label for="editEndTime">End Time</label>
                                    <input type="time" class="form-control" id="editEndTime" name="endTime" required>
                                </div>

                                <div class="form-group">
                                    <label for="editSpecialRequest">Special Request</label>
                                    <input type="text" class="form-control" id="editSpecialRequest" name="specialRequest">
                                </div>

                                <div class="form-group">
                                    <label for="editNumberOfTickets">Number of Tickets</label>
                                    <input type="number" class="form-control" id="editNumberOfTickets" name="numberOfTickets" required>
                                </div>

                                <div class="form-group">
                                    <label for="editPrice">Price</label>
                                    <input type="text" class="form-control" id="editPrice" name="price" required>
                                </div>

                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <select class="form-control" id="editStatus" name="status">
                                        <option value="Pending">Pending</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="updateUser()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openEditModal(orderItemId) {
                    // Display the spinner here
                    document.getElementById('spinner').style.display = 'block';

                    // Assuming there is an API endpoint or server-side script that returns reservation details by ID
                    fetch(`/ManageReservation/getSingleReservationDetails?orderItemId=${encodeURIComponent(orderItemId)}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('spinner').style.display = 'none';
                            // Parse the reservation details
                            const reservation = data; // Adjust this line if the data is nested or structured differently

                            const formattedStartTime = reservation.startTime.split('.')[0];
                            const formattedEndTime = reservation.endTime.split('.')[0];
                            // Now populate the form fields with the reservation details
                            document.getElementById('editReservationId').value = reservation.orderItemId;
                            document.getElementById('editEventName').value = reservation.eventName;
                            document.getElementById('editDate').value = reservation.date;
                            document.getElementById('editStartTime').value = formattedStartTime;
                            document.getElementById('editEndTime').value = formattedEndTime;
                            document.getElementById('editSpecialRequest').value = reservation.specialRequest || '';
                            document.getElementById('editNumberOfTickets').value = reservation.numberOfTickets;
                            document.getElementById('editPrice').value = reservation.price;
                            document.getElementById('editStatus').value = reservation.status;

                            // Show the modal
                            $('#editReservationModal').modal('show');
                        })
                        .catch(error => {
                            document.getElementById('spinner').style.display = 'none';
                            console.error('Error fetching reservation details:', error);
                            alert('Failed to load reservation details.');
                        });
                }

                function updateUser() {
                    const reservationId = document.getElementById('editReservationId').value;
                    const eventName = document.getElementById('editEventName').value;
                    const date = document.getElementById('editDate').value;
                    const startTime = document.getElementById('editStartTime').value;
                    const endTime = document.getElementById('editEndTime').value;
                    const specialRequest = document.getElementById('editSpecialRequest').value;
                    const numberOfTickets = document.getElementById('editNumberOfTickets').value;
                    const price = document.getElementById('editPrice').value;
                    const status = document.getElementById('editStatus').value;

                    // Assuming you have an API endpoint to handle the post request
                    fetch('/ManageReservation/updateReservationDetails', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            // If CSRF tokens are used, you need to include the CSRF token in the request header
                            // 'X-CSRF-Token': token
                        },
                        body: JSON.stringify({
                            orderItemId: reservationId,
                            eventName: eventName,
                            date: date,
                            startTime: startTime,
                            endTime: endTime,
                            specialRequest: specialRequest,
                            numberOfTickets: numberOfTickets,
                            price: price,
                            status: status
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Handle success
                            console.log('Success:', data);
                            // Close the modal
                            $('#editReservationModal').modal('hide');
                            location.reload();
                        })
                        .catch((error) => {
                            // Handle errors
                            console.error('Error:', error);
                        });
                }
                document.addEventListener('DOMContentLoaded', function() {
                    const addReservationForm = document.getElementById('addReservationForm');

                    addReservationForm.addEventListener('submit', function(event) {
                        event.preventDefault(); // Prevent the default form submission

                        const spinner = document.getElementById('spinner');
                        spinner.style.display = 'block';

                        // Collect the form data and convert it to a plain object.
                        const formData = new FormData(addReservationForm);
                        const formProps = Object.fromEntries(formData);

                        // Convert the plain object to a JSON string.
                        const jsonFormData = JSON.stringify(formProps);

                        fetch('/ManageReservation/addReservation', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                // If you are using session tokens or CSRF tokens, they need to be included here as well.
                            },
                            body: jsonFormData
                        })
                            .then(response => response.json())
                            .then(data => {
                                spinner.style.display = 'none';
                                if (data.success) {
                                    alert(data.message); // Alert the success message
                                    $('#addReservationModal').modal('hide');
                                    setTimeout(() => {
                                        location.reload(); // Reload the page to see the new history entry
                                    }, 1500);
                                } else {
                                    alert('Failed to add reservation: ' + data.message); // Alert the error message
                                }
                            })
                            .catch((error) => {
                                spinner.style.display = 'none';
                                alert('Error: ' + error.message);
                            });
                    });
                });


                function deleteUser(orderItemId) {
                    const confirmation = confirm('Are you sure you want to deactivate this reservation?');
                    if (confirmation) {
                        // Assuming you have an API endpoint to handle the request to deactivate
                        fetch(`/ManageReservation/deactivateReservation?orderItemId=${encodeURIComponent(orderItemId)}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Success:', data);
                                location.reload();
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    }
                }

            </script>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <!-- Bootstrap JS and Popper.js -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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















