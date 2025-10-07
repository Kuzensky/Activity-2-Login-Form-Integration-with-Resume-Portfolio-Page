<?php
// Start a session to track user login state
session_start();

// Check if user is already logged in by checking the session variable
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // User is logged in, redirect to the resume/portfolio page
    header("location: resume.php");
    exit;
} else {
    // User is not logged in, redirect to the login page
    header("location: login.php");
    exit;
}
?>