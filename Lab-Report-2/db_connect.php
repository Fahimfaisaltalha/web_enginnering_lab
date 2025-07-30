<?php
// FILE: db_connection.php
// --- Database Credentials ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_app_db";

// --- Create Connection using MySQLi ---
$conn = new mysqli($servername, $username, $password, $dbname);

// --- Check Connection ---
if ($conn->connect_error) {
    // If the connection fails, stop the script and show the error.
    die("Database Connection Failed: " . $conn->connect_error);
}

// Start the session on every page that includes this file.
// Sessions are used to keep the user logged in.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>