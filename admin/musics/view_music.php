<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../config.php'; // Ensure $conn and $_settings are defined

// Base URL for assets (adjust as needed)
define('BASE_URL', '/ESAMS/');

// Redirect if ID is missing or invalid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<script>alert("Music ID is required."); location.replace("./?page=musics");</script>';
    exit;
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($id === false) {
    echo '<script>alert("Invalid Music ID."); location.replace("./?page=musics");</script>';
    exit;
}

// Fetch music details with prepared statement
$stmt = $conn->prepare("SELECT m.*, 
                        COALESCE(c.name, 'Unknown Category') AS category_name, 
                        a.stage_name AS artist 
                        FROM `music_list` m 
                        LEFT JOIN `category_list` c ON m.category_id = c.id 
                        LEFT JOIN `artist_list` a ON m.artist_id = a.id 
                        WHERE m.id = ? AND m.delete_flag = 0");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<script>alert("Music ID is not valid."); location.replace("./?page=musics");</script>';
    exit;
}

$music = $result->fetch_assoc();
$stmt->close();

// Sanitize and prepare variables
$title = htmlspecialchars($music['title'] ?? 'Untitled');
$artist = htmlspecialchars($music['artist'] ?? 'Unknown Artist');
$category_name = htmlspecialchars($music['category_name'] ?? 'Unknown Category');
$description = str_replace("\n", "<br>", html_entity_decode($music['description'] ?? ''));
$status = $music['status'] ?? 0;

// Handle paths with validation
$banner_path = !empty($music['banner_path']) && file_exists(base_app . $music['banner_path']) 
    ? BASE_URL . $music['banner_path'] 
    : BASE_URL . 'uploads/default_banner.jpg';
$audio_path = !empty($music['audio_path']) && file_exists(base_app . $music['audio_path']) 
    ? BASE_URL . $music['audio_path'] 
    : '';
$audio_filename = $audio_path ? htmlspecialchars(basename($music['audio_path'])) : 'No Audio File';
?>

<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?= $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<style>
    .card-purple .card-header {
        background: #6f42c1;
        color: white;
    }
    .card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }
    .card-title {
        margin: 0;
        font-size: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .control-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    .pl-4 {
        padding-left: 1.5rem;
    }
    #BannerViewer {
        height: 30vh;
        width: 100%;
        object-fit: cover;
        border: 1px solid #6c757d;
    }
    audio {
        width: 100%;
        max-width: 300px;
        margin-top: 0.5rem;
    }
    .badge-success {
        background: #28a745;
    }
    .badge-secondary {
        background: #6c757d;
    }
    .btn {
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }
    .btn-light {
        background: #e9ecef;
        border: 1px solid #ced4da;
    }
    .btn-light:hover {
        background: #dee2e6;
    }
    .btn-primary {
        background: #007bff;
        border: none;
        color: white;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
    .btn-danger {
        background: #dc3545;
        border: none;
        color: white;
    }
    .btn-danger:hover {
        background: #b02a37;
    }
</style>

<div class="card card-outline rounded-0 card-purple">
    <div class="card-header">
        <h3 class="card-title">Music Details</h3>
        <div class="card-tools">
			<a href="<?= "/ESAMS/admin/?page=musics/manage_music&id={$id}" ?>" class="btn btn-flat btn-primary bg-primary"><span class="fas fa-edit"></span> Edit</a>
			<button id="delete_data" type="button" class="btn btn-flat btn-danger bg-danger"><span class="fas fa-trash"></span> Edit</button>
			<a href="<?= "/admin/?page=musics" ?>" class="btn btn-flat btn-light bg-light"><span class="fas fa-angle-left"></span> Back to List</a>
		</div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="form-group">
                <label for="title" class="control-label">Title:</label>
                <div class="pl-4"><?= $title ?></div>
            </div>
            <div class="form-group">
                <label for="artist" class="control-label">Artist:</label>
                <div class="pl-4"><?= $artist ?></div>
            </div>
            <div class="form-group">
                <label for="category_id" class="control-label">Category:</label>
                <div class="pl-4"><?= $category_name ?></div>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description:</label>
                <div class="pl-4"><?= $description ?: '<span class="text-muted">No description provided.</span>' ?></div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Music Banner:</label>
                <div class="d-flex justify-content-center">
                    <img src="<?= htmlspecialchars($banner_path) ?>" alt="<?= $title ?> Banner" id="BannerViewer" class="img-fluid">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Audio File:</label>
                <?php if ($audio_path): ?>
                    <div class="pl-4">
                        <audio src="<?= htmlspecialchars($audio_path) ?>" controls preload="metadata"></audio>
                    </div>
                    <div class="pl-4">
                        <a href="<?= htmlspecialchars($audio_path) ?>" target="_blank" title="Download <?= $audio_filename ?>"><?= $audio_filename ?></a>
                    </div>
                <?php else: ?>
                    <div class="pl-4"><span class="text-muted">No Audio File Added.</span></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status:</label>
                <div class="pl-4">
                    <span class="badge <?= $status == 1 ? 'badge-success' : 'badge-secondary' ?> rounded-pill px-4">
                        <?= $status == 1 ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#edit_data').on('click', function() {
            location.href = "/artist/?page=musics/manage_music&id=<?= $id ?>";
        });

        $('#delete_data').on('click', function() {
            _conf("Are you sure to delete this Music permanently?", "delete_music", [<?= $id ?>]);
        });

        function delete_music(id) {
            start_loader();
            $.ajax({
                url: "/ESAMS/classes/Master.php?f=delete_music",
                method: "POST",
                data: { id },
                dataType: "json",
                error: err => {
                    console.error('Delete error:', err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp?.status === 'success') {
                        location.replace("/artist/?page=musics");
                    } else {
                        alert_toast("An error occurred.", 'error');
                        end_loader();
                        console.error('Delete response:', resp);
                    }
                }
            });
        }
    });
</script>