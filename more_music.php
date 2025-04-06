<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = "Music List";
$page_description = "";
$category_id = null;

if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $stmt = $conn->prepare("SELECT * FROM `category_list` WHERE `id` = ? AND `delete_flag` = 0 AND `status` = 1");
    $stmt->bind_param('i', $_GET['cid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        $category_id = $category['id'];
        $page_title = htmlspecialchars($category['name']);
        $page_description = htmlspecialchars($category['description']);
    }
    $stmt->close();
}
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #1db954;
            --background: #121212;
            --card-bg: #181818;
            --text: #ffffff;
            --text-muted: #b3b3b3;
            --hover: #282828;
        }

        body {
            background: var(--background);
            color: var(--text);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .music-header {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .music-list {
            display: grid;
            gap: 15px;
        }

        .music-item {
            display: flex;
            align-items: center;
            background: var(--card-bg);
            padding: 10px;
            border-radius: 8px;
            transition: background 0.2s ease;
        }

        .music-item:hover {
            background: var(--hover);
        }

        .music-banner {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .music-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .music-details {
            flex: 1;
            overflow: hidden;
        }

        .music-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .music-description {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin: 2px 0 5px;
            line-height: 1.4;
        }

        .music-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .music-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: none;
            border: 1px solid var(--text-muted);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .music-btn:hover {
            border-color: var(--text);
            color: var(--text);
            background: var(--hover);
        }

        #player-field {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: var(--card-bg);
            border-top: 1px solid var(--hover);
            padding: 10px 20px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
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

        #player-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .play-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            border: none;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .play-btn:hover {
            background: #1ed760;
        }

        #player-slider {
            flex: 1;
            max-width: 500px;
        }

        #music-title {
            font-size: 1rem;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #music-title .artist {
            color: var(--text-muted);
        }

        #progress-container {
            height: 4px;
            background: var(--text-muted);
            border-radius: 2px;
            cursor: pointer;
        }

        #progress {
            height: 100%;
            background: var(--primary);
            width: 0;
            border-radius: 2px;
            transition: width 0.1s linear;
        }

        #timer-bar {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 5px;
        }

        #volume-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .volume-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .volume-btn:hover {
            color: var(--text);
        }

        @media (max-width: 768px) {
            #player-field {
                flex-direction: column;
                padding: 15px;
            }
            #player-slider {
                max-width: 100%;
            }
            .music-item {
                flex-direction: column;
                text-align: center;
            }
            .music-banner {
                margin: 0 auto 10px;
            }
            .music-actions {
                justify-content: center;
            }
        }
    </style>
    <div class="container">
        <h1 class="music-header"><?= $page_title ?></h1>
        <?php if ($page_description): ?>
            <p class="text-muted"><?= $page_description ?></p>
        <?php endif; ?>

        <div class="music-list">
            <?php
            $where = $category_id ? "AND `category_id` = ?" : "";
            $sql = "SELECT m.*, COALESCE(c.name, 'Unknown Category') AS `category_name`, a.stage_name AS `artist_name`
                    FROM `music_list` m
                    LEFT JOIN `category_list` c ON m.category_id = c.id
                    LEFT JOIN `artist_list` a ON m.artist_id = a.id
                    WHERE m.`status` = 1 AND m.`delete_flag` = 0 AND m.`audio_path` != '' $where
                    ORDER BY m.`title` ASC";
            $stmt = $conn->prepare($sql);
            if ($category_id) {
                $stmt->bind_param('i', $category_id);
            }
            $stmt->execute();
            $music_list = $stmt->get_result();

            if ($music_list->num_rows === 0) {
                echo '<p class="text-muted">No music found in this category.</p>';
            }

            while ($row = $music_list->fetch_assoc()):
                $banner_path = file_exists($row['banner_path']) ? $row['banner_path'] : '/ESAMS/uploads/default_banner.jpg';
            ?>
                <div class="music-item">
                    <div class="music-banner">
                        <img src="<?= htmlspecialchars($banner_path) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    </div>
                    <div class="music-details">
                        <h2 class="music-title"><?= htmlspecialchars($row['title']) ?></h2>
                        <p class="music-description"><?= htmlspecialchars($row['artist_name'] ?? 'Unknown Artist') ?> • <?= htmlspecialchars($row['category_name']) ?></p>
                    </div>
                    <div class="music-actions">
                        <a href="<?= htmlspecialchars($row['audio_path']) ?>" download="<?= htmlspecialchars($row['title'] . '.' . pathinfo($row['audio_path'], PATHINFO_EXTENSION)) ?>" class="music-btn" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="music-btn play_music" data-id="<?= $row['id'] ?>" title="Play">
                            <i class="fas fa-play"></i>
                        </button>
                        <button class="music-btn view_music_details" data-id="<?= $row['id'] ?>" title="Details">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php $stmt->close(); ?>
        </div>

        <div id="player-field">
            <div id="player-img-holder">
                <img src="/ESAMS/uploads/default_banner.jpg" alt="Now Playing">
            </div>
            <div id="player-controls">
                <button class="play-btn" id="play"><i class="fas fa-play"></i></button>
            </div>
            <div id="player-slider">
                <div id="music-title"><span id="title">Select a song</span> - <span class="artist" id="artist">Unknown</span></div>
                <div id="progress-container">
                    <div id="progress"></div>
                </div>
                <div id="timer-bar">
                    <span id="timer">0:00</span>
                    <span id="duration">0:00</span>
                </div>
            </div>
            <div id="volume-controls">
                <button class="volume-btn" id="volume-down"><i class="fas fa-volume-down"></i></button>
                <button class="volume-btn" id="volume-up"><i class="fas fa-volume-up"></i></button>
            </div>
        </div>
    </div>

    <audio id="player-el" class="d-none"></audio>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        class MusicPlayer {
            constructor() {
                this.audio = document.getElementById('player-el');
                this.bannerImg = document.querySelector('#player-img-holder img');
                this.titleEl = document.getElementById('title');
                this.artistEl = document.getElementById('artist');
                this.playBtn = document.getElementById('play');
                this.progressContainer = document.getElementById('progress-container');
                this.progress = document.getElementById('progress');
                this.timer = document.getElementById('timer');
                this.duration = document.getElementById('duration');
                this.volume = 0.5;
                this.audio.volume = this.volume;

                this.bindEvents();
            }

            bindEvents() {
                $(document).ready(() => {
                    $('.play_music').on('click', (e) => this.handlePlay(e));
                    $('.view_music_details').on('click', (e) => this.handleDetails(e));
                    $('#play').on('click', () => this.togglePlay());
                    $('#volume-down').on('click', () => this.adjustVolume('down'));
                    $('#volume-up').on('click', () => this.adjustVolume('up'));
                    this.progressContainer.addEventListener('click', (e) => this.seek(e));
                    this.audio.addEventListener('timeupdate', () => this.updateProgress());
                    this.audio.addEventListener('ended', () => this.handleEnd());
                    this.audio.addEventListener('canplaythrough', () => this.updateDuration(), { once: true });
                });
            }

            async handlePlay(e) {
                e.preventDefault();
                const id = e.currentTarget.dataset.id;
                start_loader();
                try {
                    const resp = await $.ajax({
                        url: `/ESAMS/classes/Master.php?f=get_music_details&id=${id}`,
                        dataType: 'json'
                    });
                    if (resp && resp.discPath) {
                        this.loadSong(resp);
                        $('#player-field').css('display', 'flex');
                        this.updateStreams(id);
                    } else {
                        throw new Error('Invalid song data');
                    }
                } catch (err) {
                    alert('Failed to load song. Please try again.');
                    console.error(err);
                } finally {
                    end_loader();
                }
            }

            handleDetails(e) {
                e.preventDefault();
                const id = e.currentTarget.dataset.id;
                if (typeof uni_modal === 'function') {
                    uni_modal('Music Details', `view_music_details.php?id=${id}`, 'modal-large');
                } else {
                    window.location.href = `view_music_details.php?id=${id}`;
                }
            }

            loadSong(song) {
                this.bannerImg.src = song.coverPath || '/ESAMS/uploads/default_banner.jpg';
                this.audio.src = song.discPath;
                this.titleEl.textContent = song.title || 'Unknown Title';
                this.artistEl.textContent = song.artist || 'Unknown Artist';
                this.togglePlay();
            }

            togglePlay() {
                if (this.audio.paused) {
                    this.audio.play().catch(err => console.error('Playback error:', err));
                } else {
                    this.audio.pause();
                }
                this.updatePlayIcon();
            }

            updatePlayIcon() {
                this.playBtn.querySelector('i').classList.toggle('fa-play', this.audio.paused);
                this.playBtn.querySelector('i').classList.toggle('fa-pause', !this.audio.paused);
            }

            updateProgress() {
                const percent = (this.audio.currentTime / this.audio.duration) * 100;
                this.progress.style.width = `${percent}%`;
                this.timer.textContent = this.formatTime(this.audio.currentTime);
            }

            updateDuration() {
                this.duration.textContent = this.formatTime(this.audio.duration);
            }

            formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60).toString().padStart(2, '0');
                return `${mins}:${secs}`;
            }

            seek(e) {
                const rect = this.progressContainer.getBoundingClientRect();
                const pos = (e.clientX - rect.left) / rect.width;
                this.audio.currentTime = pos * this.audio.duration;
            }

            adjustVolume(direction) {
                this.volume = direction === 'down' ? Math.max(0, this.volume - 0.1) : Math.min(1, this.volume + 0.1);
                this.audio.volume = this.volume;
            }

            handleEnd() {
                $('#player-field').hide();
            }

            async updateStreams(id) {
                try {
                    await $.post('/ESAMS/classes/update_stream.php', { id });
                    console.log('Streams updated');
                } catch (err) {
                    console.error('Stream update failed:', err);
                }
            }
        }

        // Initialize the player
        const player = new MusicPlayer();
    </script>
