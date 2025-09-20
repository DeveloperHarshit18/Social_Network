<?php
// Public index.php for Render deployment
// This redirects to the main application

// Check if user is logged in
session_start();

if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to main feed
    header('Location: ../index.php');
} else {
    // User is not logged in, redirect to login
    header('Location: ../login.php');
}
exit;
?>
