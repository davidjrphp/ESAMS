<?php
$user = $conn->query("SELECT artist_list.*, COALESCE(SUM(music_list.streams), 0) AS totalMonthlyListeners 
                      FROM artist_list 
                      LEFT JOIN music_list ON artist_list.id = music_list.artist_id 
                      WHERE artist_list.id = '" . $_settings->userdata('id') . "'");

$meta = $user->fetch_assoc();
$totalMonthlyListeners = $meta['totalMonthlyListeners'];
?>
<style>
 .card-profile{
    position: relative;
        background-position: center;
        height: auto;
        display: flex;
        border-radius: 15px;
 }
</style>

<div class="card card-profile" style="background: url(<?php echo isset($meta['avatar']) ? $meta['avatar'] : ''; ?>) no-repeat center center; background-size: cover;">
    <div class="card-body">
        <div class="container-fluid text-center">
            <div id="msg"></div>
            <div class="form-group d-flex justify-content-center">
                <img src="<?php echo isset($meta['avatar']) ? $meta['avatar'] : ''; ?>" alt="" id="cimg" class="img-fluid img-thumbnail rounded-circle" style="width: 150px; height: 150px;">
            </div>
            <h2 class="stage-name title-font" style="color: #fff; font-weight: bold; font-size: 6rem;"><?php echo isset($meta['stage_name']) ? $meta['stage_name'] : ''; ?></h2>
            <p class="Listeners title-font" style="font-size: 20px; color: #fff;"><?php echo $totalMonthlyListeners; ?> Total Plays</p>
        </div>
    </div>
</div>
