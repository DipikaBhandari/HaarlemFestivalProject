<?php
use App\model\User;


 if(isset($_SESSION['username'])) {
    include __DIR__ . '/afterlogin.php'; // Include afterlogin.php for logged-in users
} else {
     session_start();
    include __DIR__ . '/header.php'; // Include default header for non-logged-in users
}

if (!isset($user) || !$user instanceof User) {
    exit('User data is not available.');
}
?>
<div class="container mt-4">

    <!-- User Information Form -->
    <form id="userInfoForm" action="/manageAccount/show" method="post" enctype="multipart/form-data">
        <div class="profile-pic-container text-center mb-4">
            <input type="file" id="profilePictureInput" name="profilePictureInput"  accept="image/*" class="d-none"/>
            <label for="profilePictureInput" class="profile-pic-label">
                <?php if (!empty($user->getProfilePicture())): ?>
                    <img id="profilePicture" src="<?= htmlspecialchars($user->getProfilePicture()) . '?v=' . time() ?>" alt="User Avatar" class="avatar rounded-circle">
                <?php else: ?>
                    <!-- Display initials if no profile picture -->
                    <div id="defaultAvatar" class="default-avatar bg-secondary text-white rounded-circle">
                        <?= htmlspecialchars(strtoupper($user->getName()[0] ?? '') . strtoupper($user->getName()[1] ?? '')) ?> <!-- Adjust to correctly extract initials -->
                    </div>
                <?php endif; ?>
                <div class="overlay text-white">Upload</div>
            </label>
        </div>
        <!-- Name -->
        <div class="mb-3">
            <label for="userName" class="form-label">Name:</label>
            <input type="text" class="form-control" id="userName" name="name" value="<?= isset($user) ? htmlspecialchars($user->getName()) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="userPassword" class="form-label">Password:</label>
            <!-- This is a dummy field for display purposes -->
            <input type="password" class="form-control" id="userPassword" value="password" disabled>
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#passwordModal">
                Change Password
            </button>
            <div id="feedbackAlert" class="alert alert-success d-none" style="border-left: 5px solid #28a745;" role="alert">
                <span id="feedbackMessage"></span>
            </div>
        </div>
        <!-- Email -->
        <div class="mb-3">
            <label for="userEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="userEmail" name="email" value="<?= isset($user) ? htmlspecialchars($user->getEmail()): '' ?>" required>
        </div>
        <!-- Address (additional field) -->
        <div class="mb-3">
            <label for="userAddress" class="form-label">Address:</label>
            <input type="text" class="form-control" id="userAddress" name="address" value="<?= isset($user) ? htmlspecialchars($user->getAddress()) : '' ?>" >
        </div>
        <!-- Phone Number (additional field) -->
        <div class="mb-3">
            <label for="userPhoneNumber" class="form-label">Phone Number:</label>
            <input type="text" class="form-control" id="userPhoneNumber" name="phoneNumber" value="<?= isset($user) ? htmlspecialchars($user->getPhoneNumber()) : '' ?>" required>
        </div>
        <div id="feedbackAlert" class="alert alert-success d-none" style="border-left: 5px solid #28a745;" role="alert">
            <span id="feedbackMessage"></span>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    <br>
    <br>

    <div class="modal" id="passwordModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal form fields -->
                    <div class="form-group">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" class="form-control" id="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" id="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confirmNewPassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savePassword" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="../public/javascript/manageAccountPasswordUpdate.js"></script>
<script src="../public/javascript/manageAccount.js"></script>
<?php
include __DIR__ . '/footer.php';
?>

