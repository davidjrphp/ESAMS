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
    .music-img {
        width: 3em;
        height: 3em;
        object-fit: cover;
        object-position: center center;
    }
    img#BannerViewer {
        height: 30vh;
        width: 100%;
        object-fit: scale-down;
        object-position: center center;
    }
    .card-purple .card-header {
        background: #6f42c1;
        color: white;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-light {
        background: #f8f9fa;
        border: 1px solid #ced4da;
    }
    audio {
        max-width: 100%;
    }
    .badge-success {
        background: #28a745;
    }
</style>

<div class="card card-outline rounded-0 card-purple">
    <div class="card-header">
        <h3 class="card-title">Music Details</h3>
        <div class="card-tools">
            <a href="/artist/?page=musics" class="btn btn-flat btn-light bg-light"><span class="fas fa-angle-left"></span> Back to List</a>
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
                    <img src="<?= htmlspecialchars($banner_path) ?>" alt="<?= $title ?> Banner" id="BannerViewer" class="img-fluid img-thumbnail bg-gradient-dark border-dark">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Audio File:</label>
                <?php if ($audio_path): ?>
                    <div class="pl-4">
                        <audio src="<?= htmlspecialchars($audio_path) ?>" controls></audio>
                    </div>
                    <div class="pl-4">
                        <a href="<?= htmlspecialchars($audio_path) ?>" target="_blank"><?= $audio_filename ?></a>
                    </div>
                <?php else: ?>
                    <div class="pl-4"><span class="text-muted">No Audio File Added.</span></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status:</label>
                <div class="pl-4">
                    <span class="badge <?= $status == 1 ? 'badge-success' : '' ?> rounded-pill px-4">
                        <?= $status == 1 ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#delete_data').click(function() {
            _conf("Are you sure to delete this Music permanently?", "delete_music", [<?= $id ?>]);
        });

        $('#category_id').select2({
            placeholder: "Please Select Category Here",
            containerCssClass: "rounded-0"
        });

        $('#music-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: "/ESAMS/classes/Master.php?f=save_music",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        location.replace("/admin/?page=musics/view_music&id=" + resp.mid);
                    } else if (resp.status === 'failed' && !!resp.msg) {
                        var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").scrollTop(0);
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });

    function delete_music(id) {
        start_loader();
        $.ajax({
            url: "/ESAMS/classes/Master.php?f=delete_music",
            method: "POST",
            data: { id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.replace("/admin/?page=musics");
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>