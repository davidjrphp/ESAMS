<?php
require_once('./config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `music_list` where id = '{$_GET['id']}' and delete_flag = 0 ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        echo '<script>alert("Music ID is not valid."); location.replace("./?page=musics")</script>';
    }
} else {
    echo '<script>alert("Music ID is Required."); location.replace("./?page=musics")</script>';
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
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
        height: 45vh;
        width: 100%;
        object-fit: scale-down;
        object-position: center center;
    }

    .modal-content>.modal-footer {
        display: none;
    }
</style>
<div class="container-fluid">
    <div class="form-group d-flex justify-content-center">
        <img src="<?php echo validate_image((isset($banner_path) ? $banner_path : "")) ?>" alt="" id="BannerViewer" class="img-fluid img-thumbnail bg-dark border-dark">
    </div>
    <div class="form-group row">
        <label for="title" class="control-label col-md-3">Title:</label>
        <div class="col-md-9"><?= isset($title) ? $title : "" ?></div>
    </div>
    <div class="form-group row">
        <label for="artist" class="control-label col-md-3">Artist:</label>
        <div class="col-md-9"><?= isset($artist) ? $artist : "" ?></div>
    </div>
    <div class="form-group row">
        <label for="category_id" class="control-label col-md-3">Category:</label>
        <div class="col-md-9"><?= isset($category_name) ? $category_name : "" ?></div>
    </div>
    <div class="form-group row">
        <label for="streams" class="control-label col-md-3">Streams:</label>
        <div class="col-md-9"><?= isset($streams) ? $streams : "" ?></div>
    </div>
    <div class="form-group row">
        <label for="description" class="control-label col-md-3">Description:</label>
        <div class="col-md-9"><?= isset($description) ? str_replace("\n", "<br>", html_entity_decode($description)) : "" ?></div>
    </div>

    <div class="form-group row">
        <?php if (isset($audio_path) && !empty($audio_path)) : ?>
            <div class="col-md-9">
                <audio src="<?= $audio_path ?>" controls></audio>
            </div>
            <div class="col-md-9">
                <a href="<?= $audio_path ?>" target="_blank"><?= (pathinfo($audio_path, PATHINFO_FILENAME)) . "." . (pathinfo($audio_path, PATHINFO_EXTENSION))  ?></a>
            </div>
        <?php else : ?>
            <div class="col-md-9"><span class="text-muted">No Audio File Added.</span></div>
        <?php endif; ?>
    </div>
</div>