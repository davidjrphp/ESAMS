<?php
$artistId = $_settings->userdata('id'); 

$query = $conn->query("SELECT al.*, COALESCE(SUM(ml.streams), 0) AS totalMonthlyListeners, ml.title AS latest_music_title, ml.banner_path AS latest_music_banner, al.about_artist, al.email, al.sex, al.DOB FROM artist_list AS al LEFT JOIN music_list AS ml ON al.id = ml.artist_id WHERE al.id = '$artistId' GROUP BY al.id");

if ($query) {
    $meta = $query->fetch_assoc();
    $totalMonthlyListeners = $meta['totalMonthlyListeners'];
    $stageName = $meta['stage_name'];
    $email = $meta['email'];
    $sex = $meta['sex'];
    $dob = $meta['DOB'] ? date('F j, Y', strtotime($meta['DOB'])) : 'Not specified'; // Format DOB
    $aboutArtist = $meta['about_artist'];
} else {
    echo "SQL Query Error: " . $conn->error;
}
?>

<style>
    .artist-profile-card {
        border-radius: 20px;
        overflow: hidden;
        background: #1a1a1a; /* Dark background like Spotify */
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .artist-header {
        position: relative;
        height: 300px; /* Reduced height for better proportion */
        background: url(<?= file_exists($meta['avatar']) && !empty($meta['avatar']) ? $meta['avatar'] : '/ESAMS/uploads/default_banner.jpg' ?>) no-repeat center;
        background-size: cover;
        display: flex;
        align-items: flex-end;
        padding: 20px;
    }

    .artist-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.8)); /* Gradient overlay */
    }

    .artist-info {
        position: relative;
        z-index: 1;
    }

    .stage-name {
        font-size: 3rem; /* Large, bold name like Spotify */
        font-weight: 900;
        margin: 0;
        line-height: 1.1;
    }

    .total-plays {
        font-size: 1.25rem;
        color: #b3b3b3; /* Muted gray like Spotify */
        margin: 5px 0;
    }

    .artist-details {
        padding: 20px;
    }

    .about-section {
        margin-bottom: 20px;
    }

    .about-section h5 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
    }

    .about-section p {
        font-size: 1rem;
        color: #b3b3b3;
        line-height: 1.5;
        margin: 0;
    }

    .details-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .details-list li {
        font-size: 1rem;
        color: #b3b3b3;
        margin-bottom: 10px;
    }

    .details-list li strong {
        color: #fff;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .stage-name {
            font-size: 2rem;
        }

        .artist-header {
            height: 200px;
        }
    }
</style>

<div class="container-fluid">
    <h4 class="heading">About Artist</h4>
    <div class="card artist-profile-card">
        <div class="artist-header">
            <div class="artist-info">
                <h1 class="stage-name"><?= isset($stageName) ? $stageName : 'Unknown Artist' ?></h1>
                <p class="total-plays"><?= number_format($totalMonthlyListeners) ?> Total Plays</p>
            </div>
        </div>
        <div class="artist-details">
            <div class="about-section">
                <h5>About</h5>
                <p><?= isset($aboutArtist) && !empty($aboutArtist) ? $aboutArtist : 'No bio available.' ?></p>
            </div>
            <ul class="details-list">
                <li><strong>Email:</strong> <?= isset($email) ? $email : 'Not provided' ?></li>
                <li><strong>Sex:</strong> <?= isset($sex) && !empty($sex) ? $sex : 'Not specified' ?></li>
                <li><strong>Date of Birth:</strong> <?= $dob ?></li>
            </ul>
        </div>
    </div>
</div>