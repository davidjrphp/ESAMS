<?php
$artistId = $_settings->userdata('id'); 

$query = $conn->query("SELECT al.*, COALESCE(SUM(ml.streams), 0) AS totalMonthlyListeners, ml.title AS latest_music_title, ml.banner_path AS latest_music_banner, al.about_artist FROM artist_list AS al LEFT JOIN music_list AS ml ON al.id = ml.artist_id WHERE al.id = '$artistId'");

if ($query) {
    $meta = $query->fetch_assoc();
    $totalMonthlyListeners = $meta['totalMonthlyListeners'];
    // $aboutArtist = $meta['about_artist'];
} else {
    echo "SQL Query Error: " . $conn->error;
}
?>

<style>
    .card-about {
        border-radius: 50px;
    }
    .about {
        background: url(<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : ''); ?>)no-repeat center; width: 100%;
        background-size: cover;
        position: relative;
        background-position: center;
        height: 600px;
        display: flex;
        border-radius: 15px;    
    }
    .list-about, .About {
        margin-top: 500px;
        margin-left: -70rem;
        /* justify-content: start; */
    }
</style>

<h4 class="heading">About Artist</h4>
<div class="card card-about">
    <div class="card-body about">
        <div class="container-fluid text-center">
            <div id="msg"></div>
            <!-- <h2 class="stage-name title-font" style="color: #fff;"><?php echo isset($meta['stage_name']) ? $meta['stage_name'] : ''; ?></h2> -->
            <p class="Listeners list-about" style="font-size: 20px; color: #fff;"><?php echo $totalMonthlyListeners; ?> Total Plays</p>
            <p class="About" style="font-size: 20px; color: #fff;"><?php echo isset($meta['about_artist']) ? $meta['about_artist'] : ''; ?></p>
        </div>
    </div>
</div>
