<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Construct the current URL
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}
$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];

// Redirect unauthenticated users to login, unless on login page
if (!isset($_SESSION['userdata']) && !strpos($link, 'login.php')) {
    redirect('admin/login.php');
}

// Redirect authenticated users away from login page
if (isset($_SESSION['userdata']) && strpos($link, 'login.php')) {
    redirect('admin/index.php');
}

// Define module paths for login types
$module = ['', 'admin', 'tutor']; // Index 0: none, 1: admin, 2: tutor (artist?)

// Restrict access for non-admins trying to access admin areas
if (isset($_SESSION['userdata']) && 
    (strpos($link, 'index.php') || strpos($link, 'admin/')) && 
    $_SESSION['userdata']['login_type'] != 1) {
    $redirect_path = $module[$_SESSION['userdata']['login_type']];
    echo "<script>alert('Access Denied!'); location.replace('/$redirect_path');</script>";
    exit;
}