<?php
$user = $conn->query("SELECT artist_list.*, COALESCE(SUM(music_list.streams), 0) AS totalMonthlyListeners 
                      FROM artist_list 
                      LEFT JOIN music_list ON artist_list.id = music_list.artist_id 
                      WHERE artist_list.id = '" . $_settings->userdata('id') . "'");

$meta = $user->fetch_assoc();
$totalMonthlyListeners = $meta['totalMonthlyListeners'];
?>

<div class="card">
    <div class="card-body">
        <div class="container-fluid text-center">
            <div id="msg"></div>
            <div class="form-group d-flex justify-content-center">
                <img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail rounded-circle" style="width: 150px; height: 150px;">
            </div>
            <h2 class="stage-name title-font"><?php echo isset($meta['stage_name']) ? $meta['stage_name'] : '' ?></h2>
            <p class="Listeners title-font" style="font-size: 20px">Total Listeners: <?php echo $totalMonthlyListeners; ?></p>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <!-- Add any additional buttons or links for the artist's profile here -->
            </div>
        </div>
    </div>
</div>