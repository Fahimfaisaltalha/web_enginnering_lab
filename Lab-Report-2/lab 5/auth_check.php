<?php
// FILE: auth_check.php
// This file can be included at the top of any page you want to protect.
// It checks if the user is logged in. If not, it redirects them to the login page.
require_once 'db_connection.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>