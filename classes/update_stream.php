<?php
require_once('../config.php');
if (isset($_POST['id'])) {
    $music_id = $_POST['id'];


    $update_query = $conn->prepare("UPDATE music_list SET streams = streams + 1 WHERE id = ?");
    $update_query->bind_param("i", $music_id);

    if ($update_query->execute()) {
        echo "Streams updated successfully.";
    } else {
        echo "Failed to update streams.";
    }
}
