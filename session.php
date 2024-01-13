<?php
// session.php

// Start the session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, except for specific pages
$excluded_pages = array('login.html', 'signup.html'); // Add the names of public pages here

if (!isset($_SESSION['username']) && !in_array(basename($_SERVER['PHP_SELF']), $excluded_pages)) {
    // Redirect the user to the login page if not logged in and not on an excluded page
    header("Location: login.php");
    exit(); // Stop executing further code
}

// If needed, you can store additional session data or perform other session-related tasks here
?>