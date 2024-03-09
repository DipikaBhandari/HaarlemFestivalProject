<?php
use App\model\user;

if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
    session_start();

     // Include default header for non-logged-in users
}

if (!isset($user) || !$user instanceof user) {
    exit('User data is not available.');
}
?>
<head>
    <title>Manage Users</title>
</head>

<div class="ts-main-content">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name or email...">
                </div>
                <div class="col-md-4">
                    <select id="roleFilter" class="form-control">
                        <option value="">Filter by Role</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Customer">Customer</option>
                    </select>
                </div>
                    <h2 class="page-title">Manage Users</h2>
                </div>
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">List Users</div>
                        <div class="panel-body">
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Registered Date</th>
                                    <th>Role</th>

                                    <th>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                                            Add User
                                        </button>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td></td>
                                            <td><img src="../img/<?php echo htmlentities($user['picture'] ?? 'default.jpg');?>" style="width:50px; border-radius:50%;"/></td>
                                            <td><?php echo htmlentities($user['username'] ?? 'N/A');?></td>
                                            <td><?php echo htmlentities($user['email'] ?? 'N/A');?></td>
                                            <td><?php echo htmlentities($user['address'] ?? 'N/A');?></td>
                                            <td><?php echo htmlentities($user['phonenumber']);?></td>
                                            <td><?php
                                                if (!empty($user['registered_at'])) {
                                                    $registeredDate = new DateTime($user['registered_at']);
                                                    echo $registeredDate->format('Y-m-d'); // Formats the date as Year-Month-Day
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?></td>


                                            <td><?php echo htmlentities($user['role']);?></td>
                                            <td>
                                                <a onclick="openEditModal('<?php echo htmlentities($user['username']);?>')" >&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                                <a onclick="deleteUser('<?php echo htmlentities($user['username']); ?>')" ><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
                                            </td>

                                        </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #2a2a72; color: white;">
            <div class="modal-header" style="border-bottom: none; background-color: #006D77;">
                <h5 class="modal-title" id="addUserModalLabel" style="color: white;">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add User Form -->
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="user">Customer</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #006D77; color: white;">Add User</button>
                </form>
            </div>
        </div>
    </div>
    </div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <!-- Include other fields as necessary -->
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="tel" class="form-control" id="editPhone" name="phonenumber" placeholder="Enter phone" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="editRole" name="role" class="form-control">
                            <option value="user">Customer</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <!-- Add other fields as needed -->
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const tableRows = document.querySelectorAll('#zctb tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const filterRole = roleFilter.value;

            tableRows.forEach(row => {
                const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const role = row.querySelector('td:nth-child(8)').textContent;

                const textMatch = username.includes(searchText) || email.includes(searchText);
                const roleMatch = filterRole === '' || role === filterRole;

                if (textMatch && roleMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
        roleFilter.addEventListener('change', filterTable);
    });
</script>

<script>
    function openEditModal(username) {
        fetch(`/ManageUsers/getUserDetails?username=${encodeURIComponent(username)}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Ensure we're accessing the first element of the array if the data is encapsulated as such.
                const userDetails = data[0]; // Adjust this line to properly access the user details.


                document.getElementById('editUserId').value = userDetails.id;
                document.getElementById('editUsername').value = userDetails.username;
                document.getElementById('editEmail').value = userDetails.email;
                document.getElementById('editAddress').value = userDetails.address;
                document.getElementById('editPhone').value = userDetails.phonenumber;
                document.getElementById('editRole').value = userDetails.role;

                // Trigger modal display
                $('#editUserModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching user details:', error);
                alert('Failed to load user details.');
            });
    }


    function updateUser() {
        const userData = {
            id: document.getElementById('editUserId').value,
            username: document.getElementById('editUsername').value,
            email: document.getElementById('editEmail').value,
            address: document.getElementById('editAddress').value,
            phonenumber: document.getElementById('editPhone').value,
            role: document.getElementById('editRole').value,
        };

        fetch('/ManageUsers/updateUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Include CSRF token if needed
            },
            body: JSON.stringify(userData),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User updated successfully');
                    $('#editUserModal').modal('hide');
                    // Optionally, refresh the page or re-fetch user list here
                } else {
                    alert('Failed to update user');
                }
            })
            .catch(error => {
                console.error('Error updating user:', error);
                alert('Error updating user');
            });
    }
</script>

<script>
    function deleteUser(username) {
        if(confirm('Do you want to delete this user?')) {
            fetch('/ManageUsers/deleteUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({username: username}),
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('User deleted successfully');
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to update user.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error deleting user');
                });
        }
    }
</script>

<script>
            document.addEventListener('DOMContentLoaded', function() {
                const addUserForm = document.getElementById('addUserForm');

                addUserForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(addUserForm);
                    const userData = {
                        username: formData.get('username'),
                        email: formData.get('email'),
                        address: formData.get('address'),
                        phoneNumber: formData.get('phoneNumber'),
                        password: formData.get('password'),
                        role: formData.get('role')
                    };

                    fetch('/ManageUsers/addUser', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(userData),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('User added successfully');
                                $('#addUserModal').modal('hide');
                                location.reload(); // Reload the page or redirect as needed
                            } else {
                                alert('Failed to add user: ' + data.message);
                            }
                        })
                        .catch((error) => {
                            alert('Error: ' + error);
                        });
                });
            });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php
include __DIR__ . '/footer.php';
?>
