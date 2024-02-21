<?php

use App\model\User;

include __DIR__ . '/header.php';
if (!isset($user) || !$user instanceof User) {
    exit('User data is not available.');
}
?>
<div class="container mt-4">
<!-- Profile Picture Upload Section -->


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
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="/manageAccount.js"></script>
<?php
include __DIR__ . '/footer.php';
?>
