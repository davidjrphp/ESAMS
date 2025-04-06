<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php'; 

// Base URL for assets (adjust based on your server root)
define('BASE_URL', '/ESAMS/'); // Ensure this matches your document root, e.g., http://localhost:8088/ESAMS/

$page_title = "Music List";
$page_description = "";
$category_id = null;
if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $cat_qry = $conn->prepare("SELECT * FROM `category_list` WHERE `id` = ? AND `delete_flag` = 0 AND `status` = 1");
    $cat_qry->bind_param('i', $_GET['cid']);
    $cat_qry->execute();
    $result = $cat_qry->get_result();
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        $category_id = $category['id'];
        $page_title = htmlspecialchars($category['name']);
        $page_description = htmlspecialchars($category['description']);
    }
    $cat_qry->close();
}
?>

<style>
    .music-list-container {
        background: #121212;
        padding: 20px;
        border-radius: 10px;
        color: #fff;
    }

    .music-list-header {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #fff;
    }

    .music-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        background: #181818;
        margin-bottom: 10px;
        transition: background 0.2s ease;
    }

    .music-item:hover {
        background: #282828;
    }

    .music-banner {
        width: 60px;
        height: 60px;
        margin-right: 15px;
        border-radius: 4px;
        overflow: hidden;
    }

    .music-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .music-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .music-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .music-artist, .music-category {
        font-size: 0.9rem;
        color: #b3b3b3;
        margin: 2px 0;
    }

    .music-streams {
        font-size: 0.85rem;
        color: #1db954;
    }

    .music-actions {
        display: flex;
        align-items: center;
    }

    .music-btns {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        background: none;
        border: 1px solid #b3b3b3;
        color: #b3b3b3;
        transition: all 0.2s ease;
    }

    .music-btns:hover {
        border-color: #fff;
        color: #fff;
        background: #333;
    }

    .music-btns i {
        font-size: 1rem;
    }

    #player-field {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #181818;
        padding: 10px 20px;
        border-top: 1px solid #282828;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #player-img-holder {
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }

    #player-img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    #player-slider {
        flex: 1;
        margin: 0 20px;
    }

    #music-title {
        font-size: 1rem;
        color: #fff;
        margin-bottom: 5px;
    }

    #music-title .artist {
        color: #b3b3b3;
    }

    #progress-container {
        height: 4px;
        background: #404040;
        border-radius: 2px;
        cursor: pointer;
    }

    #progress {
        background: #1db954;
        height: 100%;
        width: 0;
        border-radius: 2px;
        transition: width 0.1s ease;
    }

    #timer-bar {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #b3b3b3;
        margin-top: 5px;
    }

    .play-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        color: #000;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
</style>

<div class="container-fluid music-list-container">
    <h4 class="music-list-header"><?= htmlspecialchars($page_title) ?></h4>
    <div class="row">
        <div class="col-12">
            <?php
            $sql = "SELECT m.*, c.name AS `category_name`, a.stage_name AS `artist_name` 
                    FROM `music_list` m 
                    LEFT JOIN `category_list` c ON m.category_id = c.id 
                    LEFT JOIN `artist_list` a ON m.artist_id = a.id 
                    WHERE m.`status` = 1 AND m.`delete_flag` = 0 AND m.`audio_path` != '' 
                    AND m.`artist_id` = ? " . ($category_id ? "AND m.`category_id` = ?" : "") . " 
                    ORDER BY m.`streams` DESC";

            $stmt = $conn->prepare($sql);
            if ($category_id) {
                $stmt->bind_param('ii', $_SESSION['userdata']['id'], $category_id);
            } else {
                $stmt->bind_param('i', $_SESSION['userdata']['id']);
            }
            $stmt->execute();
            $music_list = $stmt->get_result();

            if ($music_list->num_rows == 0) {
                echo "<p>No music found for this artist" . ($category_id ? " in this category" : "") . ".</p>";
            }

            while ($row = $music_list->fetch_assoc()) :
                // Fix paths with validation
                $banner_path = !empty($row['banner_path']) && file_exists(base_app . $row['banner_path']) 
                    ? BASE_URL . $row['banner_path'] 
                    : BASE_URL . 'uploads/default_banner.jpg';
                $audio_path = !empty($row['audio_path']) && file_exists(base_app . $row['audio_path']) 
                    ? BASE_URL . $row['audio_path'] 
                    : '';
            ?>
                <div class="music-item">
                    <div class="music-banner">
                        <img src="<?= htmlspecialchars($banner_path) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    </div>
                    <div class="music-details">
                        <div class="music-title"><?= htmlspecialchars($row['title']) ?></div>
                        <div class="music-artist"><?= htmlspecialchars($row['artist_name'] ?? 'Unknown Artist') ?></div>
                        <div class="music-category"><?= htmlspecialchars($row['category_name'] ?? 'Unknown Category') ?> • <span class="music-streams"><?= number_format($row['streams']) ?> streams</span></div>
                    </div>
                    <div class="music-actions">
                        <?php if ($audio_path): ?>
                            <a href="<?= htmlspecialchars($audio_path) ?>" download="<?= htmlspecialchars($row['title'] . '.' . pathinfo($row['audio_path'], PATHINFO_EXTENSION)) ?>" class="music-btns"><i class="fa fa-download"></i></a>
                            <a href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-audio="<?= htmlspecialchars($audio_path) ?>" data-banner="<?= htmlspecialchars($banner_path) ?>" class="music-btns play_music"><i class="fa fa-play"></i></a>
                        <?php endif; ?>
                        <a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="music-btns view_music_details"><i class="fa fa-info"></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php $stmt->close(); ?>
        </div>
    </div>

    <div id="player-field">
        <div id="player-img-holder">
            <img src="<?= htmlspecialchars(BASE_URL . 'uploads/default_banner.jpg') ?>" alt="">
        </div>
        <button class="play-btn" id="play"><i class="fa fa-play"></i></button>
        <div id="player-slider">
            <div id="music-title"><span id="title">Music Title</span> - <span class="artist" id="artist">Artist</span></div>
            <div id="progress-container">
                <div id="progress"></div>
            </div>
            <div id="timer-bar">
                <span id="timer">0:00</span>
                <span id="duration"></span>
            </div>
        </div>
    </div>
    <audio src="" class="d-none" id="player-el"></audio>

    <script>
        const disc = document.getElementById('player-el');
        const play = document.getElementById('play');
        disc.volume = 0.5;

        $(function() {
            $('.view_music_details').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                if (typeof uni_modal === 'function') {
                    uni_modal("Music Details", "view_music_details.php?id=" + id, "modal-large");
                } else {
                    console.log('uni_modal not defined');
                    window.location.href = "view_music_details.php?id=" + id;
                }
            });

            $('.play_music').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var audioPath = $(this).attr('data-audio');
                var bannerPath = $(this).attr('data-banner');
                if (typeof start_loader === 'function') start_loader();

                // Use local paths instead of AJAX if available
                if (audioPath) {
                    disc.src = audioPath;
                    document.querySelector('#player-img-holder img').src = bannerPath;
                    document.getElementById('title').textContent = $(this).closest('.music-item').find('.music-title').text();
                    document.getElementById('artist').textContent = $(this).closest('.music-item').find('.music-artist').text();
                    $('#player-field').css('display', 'flex');
                    disc.play().catch(err => console.error('Play error:', err));
                    if (typeof end_loader === 'function') end_loader();

                    // Update streams via AJAX
                    $.ajax({
                        url: "/ESAMS/classes/Master.php?f=update_streams",
                        method: "POST",
                        data: { id: id },
                        error: err => console.error('Stream update failed:', err),
                        success: resp => console.log('Streams updated:', resp)
                    });
                } else {
                    $.ajax({
                        url: "/ESAMS/classes/Master.php?f=get_music_details&id=" + id,
                        dataType: "json",
                        error: err => {
                            alert("Error fetching audio file.");
                            if (typeof end_loader === 'function') end_loader();
                            console.error(err);
                        },
                        success: function(resp) {
                            if (typeof resp === 'object' && resp.discPath) {
                                disc.src = resp.discPath;
                                document.querySelector('#player-img-holder img').src = resp.coverPath || '<?= htmlspecialchars(BASE_URL . 'uploads/default_banner.jpg') ?>';
                                document.getElementById('title').textContent = resp.title;
                                document.getElementById('artist').textContent = resp.artist;
                                $('#player-field').css('display', 'flex');
                                disc.play().catch(err => console.error('Play error:', err));
                            } else {
                                alert("Invalid audio file data.");
                                console.error(resp);
                            }
                            if (typeof end_loader === 'function') end_loader();
                        }
                    });
                }
            });

            $('#play').click(function(e) {
                e.preventDefault();
                if (disc.paused) {
                    disc.play().catch(err => console.error('Play error:', err));
                } else {
                    disc.pause();
                }
                play.querySelector('i').classList.toggle('fa-play', disc.paused);
                play.querySelector('i').classList.toggle('fa-pause', !disc.paused);
            });

            disc.addEventListener('timeupdate', function() {
                var progress = (disc.currentTime / disc.duration) * 100;
                document.getElementById('progress').style.width = progress + '%';
                var current = formatTime(disc.currentTime);
                var total = formatTime(disc.duration);
                document.getElementById('timer').textContent = current;
                document.getElementById('duration').textContent = total;
            });

            function formatTime(seconds) {
                var minutes = Math.floor(seconds / 60);
                var secs = Math.floor(seconds % 60);
                return minutes + ':' + (secs < 10 ? '0' + secs : secs);
            }
        });
    </script>
</div>