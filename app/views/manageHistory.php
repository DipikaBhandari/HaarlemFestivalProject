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
?>

<head>
    <title>Manage History</title>
</head>

<div class="ts-main-content">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">

                <div id="spinner" class="spinner" style="display:none;"></div>

                <h2 class="page-title">Manage History</h2>
            </div>
            <!-- Zero Configuration Table -->
            <div class="panel panel-default">
                <div class="panel-heading">List History details</div>
                <div class="panel-body">
                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>

                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Guide Name</th>
                            <th>Language</th>
                            <th>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHistoryModal">
                                    Add History
                                </button>

                            </th>
                            <!-- Add more headers if needed -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($historys as $history): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($history['date']); ?></td>
                                <td>
                                    <?php
                                    $startTime = $history['startTime'];
                                    $endTime = $history['endTime'];

                                    // Extract only the hours and minutes part
                                    $formattedStartTime = substr($startTime, 0, 5);
                                    $formattedEndTime = substr($endTime, 0, 5);

                                    echo htmlspecialchars($formattedStartTime . ' - ' . $formattedEndTime);
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($history['guideName']); ?></td>
                                <td>
                                    <?php
                                    // Split the languageIndicator string into an array of image paths
                                    $imagePaths = explode(',', $history['languageIndicator']);
                                    foreach ($imagePaths as $imagePath):
                                        $imagePath = trim($imagePath); // Trim any whitespace
                                        ?>
                                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Language Image" style="max-width: 30px; margin-right: 5px;">
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <a onclick="openEditModal('<?php echo htmlentities($history['historyId']);?>')" >&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a onclick="deleteUser('<?php echo htmlentities($history['historyId']); ?>')" ><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




<!-- Add history Modal -->
<!-- Add History Modal Content -->
<div class="modal fade" id="addHistoryModal" tabindex="-1" role="dialog" aria-labelledby="addHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #2a2a72; color: white;">
            <div class="modal-header" style="border-bottom: none; background-color: #006D77;">
                <h5 class="modal-title" id="addHistoryModalLabel" style="color: white;">Add History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addHistoryForm">
                    <!-- Date -->
                    <div class="form-group">
                        <label for="historyDate">Date</label>
                        <input type="date" class="form-control" id="historyDate" name="date" required>
                    </div>
                    <!-- Time -->
                    <div class="form-group">
                        <label for="historyStartTime">Start Time</label>
                        <input type="time" class="form-control" id="historyStartTime" name="startTime" min="10:00" max="19:00" required>

                        <label for="historyEndTime">End Time</label>
                        <input type="time" class="form-control" id="historyEndTime" name="endTime" min="10:00" max="19:00" required>
                    </div>
                    <!-- Guide -->
                    <div class="form-group">
                        <label for="historyGuide">Guide</label>
                        <select class="form-control" id="historyGuide" name="guideId" required>
                            <?php foreach ($guides as $guide): ?>
                                <option value="<?= htmlspecialchars($guide['guideId']); ?>"><?= htmlspecialchars($guide['guideName']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <?php
                        $languageImagesDirectory = '/img/languages/';

                        // Generate URLs for images. Assuming the images are directly accessible under the web root.
                        $languageImageFiles = glob($_SERVER['DOCUMENT_ROOT'] . $languageImagesDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

                        // Loop through files and adjust how you display them
                        foreach ($languageImageFiles as $index => $filePath) {
                            // Convert file system path to URL
                            $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);
                            $imageUrl = $relativePath; // Now correctly use $imageUrl for the image source
                            ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="languageIndicators[]" id="languageIndicator<?php echo $index; ?>" value="<?php echo htmlspecialchars($imageUrl); ?>">
                                <label class="form-check-label" for="languageIndicator<?php echo $index; ?>">
                                    <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Language Image" style="max-width: 30px; margin-right: 5px;">
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer" style="border-top: none; background-color: #006D77;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save History</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Edit history Modal -->
    <div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #2a2a72; color: white;">
                <div class="modal-header" style="border-bottom: none; background-color: #006D77;">
                    <h5 class="modal-title" id="editHistoryModalLabel" style="color: white;">Edit History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editHistoryForm">
                        <!-- Date -->
                        <div class="form-group">
                            <label for="editHistoryDate">Date</label>
                            <input type="date" class="form-control" id="editHistoryDate" name="date" required>
                        </div>
                        <!-- Time -->
                        <div class="form-group">
                            <label for="editHistoryStartTime">Start Time</label>
                            <input type="time" class="form-control" id="editHistoryStartTime" name="startTime" required>

                            <label for="editHistoryEndTime">End Time</label>
                            <input type="time" class="form-control" id="editHistoryEndTime" name="endTime" required>
                        </div>
                        <!-- Guide -->
                        <div class="form-group">
                            <label for="editHistoryGuide">Guide</label>
                            <select class="form-control" id="editHistoryGuide" name="guideId" required>
                                <!-- Guide options will be populated dynamically -->
                            </select>
                        </div>
                        <!-- Language Indicators -->
                        <div class="form-group">
                            <!-- Language indicator checkboxes will be populated dynamically -->
                        </div>
                        <input type="hidden" id="editHistoryId" name="historyId">
                        <div class="modal-footer" style="border-top: none; background-color: #006D77;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update History</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<style>
    .spinner {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
        margin: auto;
        position: fixed; /* or absolute */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addHistoryForm = document.getElementById('addHistoryForm');

        addHistoryForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const spinner = document.getElementById('spinner');
            spinner.style.display = 'block';

            const formData = new FormData(addHistoryForm);
            // Get all selected language indicators and join them into a string
            const languageIndicators = formData.getAll('languageIndicators[]').join(',');
            formData.set('languageIndicator', languageIndicators);

            fetch('/ManageHistory/addHistory', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    spinner.style.display = 'none';
                    if (data.success) {
                        alert(data.message); // Alert the success message
                        $('#addHistoryModal').modal('hide');
                        setTimeout(() => {
                            location.reload(); // Reload the page to see the new history entry
                        }, 1500);
                    } else {
                        alert('Failed to add history: ' + data.message); // Alert the error message
                    }
                })
                .catch((error) => {
                    spinner.style.display = 'none';
                    alert('Error: ' + error.message);
                });
        });
    });

    // function to delete history by ID
    function deleteUser(historyId) {
        if (confirm('Are you sure you want to delete this history?')) {
            const spinner = document.getElementById('spinner');
            spinner.style.display = 'block';

            // Send a fetch request to delete the history
            fetch('/ManageHistory/deleteHistory', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ historyId: historyId })
            })
                .then(response => response.json())
                .then(data => {
                    spinner.style.display = 'none';
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Failed to delete history: ' + data.message);
                    }
                })
                .catch((error) => {
                    spinner.style.display = 'none';
                    alert('Error: ' + error.message);
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
include __DIR__ . '/footer.php';
?>

