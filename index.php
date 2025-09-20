<?php
// Main index.php for Render deployment
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// If logged in, redirect to main feed
header('Location: main.php');
exit;
?>